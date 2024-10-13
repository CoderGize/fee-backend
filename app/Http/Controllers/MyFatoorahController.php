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
            ],200);
        } catch (\Exception $e) {
            $response = ['IsSuccess' => 'false', 'Message' => $e->getMessage()];
            return response()->json($response,400);
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
        $order = Order::with('designer', 'user')->findOrFail($orderId);
        $callbackURL = route('myfatoorah.callback');


        $customerName = null;
        $customerEmail = null;
        $customerMobile = null;


        if ($order->user) {
            $customerName = $order->f_name . ' ' . $order->l_name;
            $customerEmail = $order->order_email;
            $customerMobile = $order->phone ?? '12345678';
        }

        elseif ($order->designer) {
            $customerName = $order->f_name . ' ' . $order->l_name;
            $customerEmail = $order->designer->email;
            $customerMobile = $order->designer->mobile ?? '12345678';
        }

        elseif ($order->is_guest) {
            $customerName = $order->guest_name .' '.$order->guest_l_name;
            $customerEmail = $order->guest_email;
            $customerMobile = $order->guest_phone ?? '12345678';
        }
        else {
            return response()->json(['error' => 'Order must belong to a user, designer, or guest'], 400);
        }


        return [
            'CustomerName' => $customerName,
            'InvoiceValue' => $order->total_price,
            'DisplayCurrencyIso' => 'KWD',
            'CustomerEmail' => $customerEmail,
            'CallBackUrl' => $callbackURL,
            'ErrorUrl' => $callbackURL,
            'MobileCountryCode' => '+965',
            'CustomerMobile' => $customerMobile,
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

            $cart=Cart::where('user_id',$payment->user_id)->orWhere('designer_id',$payment->designer_id)->first();



            if (!$payment && $order) {
                throw new \Exception("Payment and order not found ");

            }

            $queryParams = [];

            if ($data->InvoiceStatus == 'Paid') {
                $payment->status = 'paid';
                $order->status = 'paid';
                $order->on_cash=0;

                if($shipment){
                    $shipment->paid_status = 'paid';
                }

                if($cart){
                    $cart->delete();
                }

                foreach ($order->products as $product) {
                    $orderedQuantity = $product->pivot->quantity;
                    if ($product->quantity >= $orderedQuantity) {
                        $product->quantity -= $orderedQuantity;
                        $product->save();
                    } else {
                        return response()->json(['message' => 'Product out of stock.'], 400);
                    }
                }


                $msg = 'Payment successful! Your order has been placed. ';
                $queryParams['status'] = 'success';
                $queryParams['message'] = $msg;
                $queryParams['order_id']=$order->id;
            } else if ($data->InvoiceStatus == 'Failed') {
                $payment->status = 'failed';
                $order->status = 'failed';

                if($shipment){
                    $shipment->paid_status = 'failed';
                }
                $msg = 'Payment failed. Please try again.';
                $queryParams['status'] = 'failed';
                $queryParams['message'] = $msg;
                $queryParams['order_id']=$order->id;
            } else if ($data->InvoiceStatus == 'Expired') {
                $payment->status = 'expired';
                $order->status = 'expired';
                if($shipment){
                    $shipment->paid_status = 'expired';
                }

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

            if($shipment){
                $shipment->save();
            }



            $redirectUrl = 'https://fee-website.netlify.app/payment/response?' . http_build_query($queryParams);


            return redirect()->away($redirectUrl);

        } catch (\Exception $e) {

            $redirectUrl = 'https://fee-website.netlify.app/payment/response?status=error&message=' . urlencode($e->getMessage());
            return redirect()->away($redirectUrl);
        }
    }


//-----------------------------------------------------------------------------------------------------------------------------------------
}
