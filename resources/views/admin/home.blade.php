<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @include('admin.css')
</head>

<body class="g-sidenav-show bg-gray-100">
<style>
    #productSalesChart {
        width: 400px !important;
        height: 400px !important;
    }
    #salesLineChart {
        width: 100% !important;
        height: 400px !important;
    }
    #gap{
        gap:120px;
    }
    #gap1{
        gap:112px;
    }
    #gap2{
        gap:95px;
    }
    #gap0{
        gap:80px;
    }
    #gap4{
        gap:73px;
    }
</style>
    @include('admin.sidebar')

    <main class="main-content position-relative border-radius-lg ">
        @include('admin.navbar')

        <div class="container-fluid py-4">

            <div class="row">
            <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="gap0" class="d-flex align-items-center">
                                <div class="me-3">
                                    <h1 class="display-2"><i class="fas fa-shopping-cart"></i></h1>
                                </div>
                                <div>
                                    <h6>Total Orders</h6>
                                    <h3>{{ $totalOrders }}</h3>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="gap1" class="d-flex align-items-center">
                                <div class="me-3">
                                    <h1 class="display-2"><i class="fas fa-dollar-sign"></i></h1>
                                </div>
                                <div>
                                    <h6>Total Revenue</h6>
                                    <h3>${{ number_format($totalRevenue, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                     </div>

                </div>
                <div class="col-lg-3 col-sm-6">
                   <div class="card">
                        <div class="card-body">
                            <div id="gap2" class="d-flex align-items-center">
                                <div class="me-3">
                                    <h1 class="display-2"><i class="fas fa-box"></i></h1>
                                </div>
                                <div>
                                    <h6>Total Products</h6>
                                    <h3>{{ $totalProducts }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="gap" class="d-flex align-items-center">
                                <div class="me-3">
                                    <h1 class="display-2"><i class="fas fa-chart-line"></i></h1>
                                </div>
                                <div>
                                    <h6>Sales Rate</h6>
                                    <h3>{{ number_format($salesRate, 2) }}%</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 15px;" class="col-lg-3 col-sm-6">
                   <div class="card">
                        <div class="card-body">
                            <div id="gap4" class="d-flex align-items-center">
                                <div class="me-3">
                                    <h1 class="display-2"><i class="fas fa-users"></i></h1>
                                </div>
                                <div>
                                    <h6> Total Users</h6>
                                    <h3>{{ $totalUsers }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 15px;" class="col-lg-3 col-sm-6">
                <div class="card">
                        <div class="card-body">
                            <div id="gap0" class="d-flex align-items-center">
                                <div class="me-3">
                                    <h1 class="display-2"><i class="fas fa-user-tie"></i></h1>
                                </div>
                                <div>
                                    <h6> Total Designers</h6>
                                    <h3>{{ $totalDesigners }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="row mt-4">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h6>Top Customers</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($topCustomers as $customer)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>{{ $customer->f_name }} {{ $customer->l_name }}</span>
                                        <span>{{ $customer->orders_count }} Orders</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h6>Product Sales Summary</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="productSalesChart" width="200" height="200"></canvas>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h6>Sales Line Chart</h6>
                            <!-- Form to select start and end dates -->
                            <form method="GET" action="{{ route('admin.home') }}">
                                <div class="row col-lg-6">
                                    <div class="col">
                                        <input type="date" name="start_date" class="form-control" style="width: 200px;" placeholder="Start Date">
                                    </div>
                                    <div class="col">
                                        <input type="date" name="end_date" class="form-control" style="width: 200px;" placeholder="End Date">
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <canvas id="salesLineChart"></canvas>
                        </div>
                    </div>
                </div>

            @include('admin.footer')
        </div>
    </main>

    @include('admin.script')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Product Sales Pie Chart
        const ctx = document.getElementById('productSalesChart').getContext('2d');
        const productSalesChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: @json($productSales->pluck('name')),
                datasets: [{
                    label: 'Sales',
                    data: @json($productSales->pluck('sales')),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });

          // Sales Line Chart
          const salesCtx = document.getElementById('salesLineChart').getContext('2d');
        const salesLineChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: @json($salesData->pluck('date')),
                datasets: [{
                    label: 'Total Sales',
                    data: @json($salesData->pluck('total_sales')),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Sales ($)'
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>
