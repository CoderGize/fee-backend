<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\Wishlist;
use MyFatoorah\Library\PaymentMyfatoorahApiV2;

class MyFatoorahController extends Controller {

    public $mfObj;

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * create MyFatoorah object
     */
    public function __construct() {
        $this->mfObj = new PaymentMyfatoorahApiV2(config('myfatoorah.api_key'), config('myfatoorah.country_iso'), config('myfatoorah.test_mode'));
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Create MyFatoorah invoice
     *
     * @return \Illuminate\Http\Response
     */
    public function index($orderId)
    {
        try {
            $order = Order::findOrFail($orderId);

            $paymentMethodId = 0;

            $curlData = $this->getPayLoadData($orderId);
            $data     = $this->mfObj->getInvoiceURL($curlData, $paymentMethodId);

            // return redirect()->to($data['invoiceURL']);

            return response()->json([
                'IsSuccess' => 'true',
                'invoiceURL'=>$data['invoiceURL']
            ]);
        } catch (\Exception $e) {
            $response = ['IsSuccess' => 'false', 'Message' => $e->getMessage()];
            return response()->json($response);
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     *
     * @param int|string $orderId
     * @return array
     */
    private function getPayLoadData($orderId)
    {
        $order = Order::with('user')->findOrFail($orderId);
        $callbackURL = route('myfatoorah.callback');

        return [
            'CustomerName' => $order->user->f_name . " " .$order->user->l_name,
            'InvoiceValue' => $order->total_price,
            'DisplayCurrencyIso' => 'KWD',
            'CustomerEmail' => $order->user->email,
            'CallBackUrl' => $callbackURL,
            'ErrorUrl' => $callbackURL,
            'MobileCountryCode' => '+965',
            'CustomerMobile' => $order->user->mobile ?? '12345678',
            'Language' => 'en',
            'CustomerReference' => $orderId,
            'SourceInfo' => 'Laravel ' . app()::VERSION . ' - MyFatoorah Package ' . MYFATOORAH_LARAVEL_PACKAGE_VERSION,
        ];
    }


//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Get MyFatoorah payment information
     *
     * @return \Illuminate\Http\Response
     */
    public function callback() {
        try {
            $paymentId = request('paymentId');
            $data = $this->mfObj->getPaymentStatus($paymentId, 'PaymentId');


            $payment = Payment::where('order_id', $data->CustomerReference)->first();
            $order = Order::with('user')->findOrFail($data->CustomerReference);
            $shipment=Shipment::where('order_id',$order->order)->first();

            $cart=Cart::where('user_id',$order->user_id)->first();



            if (!$payment && $order) {
                throw new \Exception("Payment and order not found ");

            }

            $queryParams = [];

            if ($data->InvoiceStatus == 'Paid') {
                $payment->status = 'paid';
                $order->status = 'paid';
                $shipment->paid_status = 'paid';
                $cart->delete();

                $msg = 'Payment successful! Your order has been placed. ';
                $queryParams['status'] = 'success';
                $queryParams['message'] = $msg;
                $queryParams['order_id']=$order->id;
            } else if ($data->InvoiceStatus == 'Failed') {
                $payment->status = 'failed';
                $order->status = 'failed';
                $shipment->paid_status = 'failed';
                $msg = 'Payment failed. Please try again.';
                $queryParams['status'] = 'failed';
                $queryParams['message'] = $msg;
                $queryParams['order_id']=$order->id;
            } else if ($data->InvoiceStatus == 'Expired') {
                $payment->status = 'expired';
                $order->status = 'expired';
                $shipment->paid_status = 'expired';
                $msg = 'Payment expired. Please try again.';
                $queryParams['status'] = 'expired';
                $queryParams['message'] = $msg;
                $queryParams['order_id']=$order->id;
            } else {
                $msg = 'Unknown payment status.';
                $queryParams['status'] = 'error';
                $queryParams['message'] = $msg . ' '. $paymentId;
                $queryParams['order_id']=$order->id;
            }


            $payment->save();
            $order->save();
            $shipment->save();


            $redirectUrl = 'https://fee-website.vercel.app/payment/response?' . http_build_query($queryParams);


            return redirect()->away($redirectUrl);

        } catch (\Exception $e) {

            $redirectUrl = 'https://fee-website.vercel.app/payment/response?status=error&message=' . urlencode($e->getMessage());
            return redirect()->away($redirectUrl);
        }
    }


//-----------------------------------------------------------------------------------------------------------------------------------------
}
