<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description"
        content="different types of invoice/bill/tally designed with friendly and markup using modern technology, you can use it on any type of website invoice, fully responsive and w3 validated." />
    <meta name="keywords"
        content="bill , receipt, tally, invoice, cash memo, invoice html, invoice pdf, invoice print, invoice templates, multipurpose invoice, template, booking invoice, general invoice, clean invoice, catalog, estimate, proposal" />
    <meta name="author" content="initTheme" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" type="image/png" href="{{ url('logo', $general_setting->site_logo) }}" />
    <title>{{ $general_setting->site_title }}</title>
    <!-- Style -->
    <link rel="stylesheet" type="text/css" href="https://www.shonkhonilcollection.com/frontend/css/main-style.css" />
</head>
<style>
    @media print {
        @page {
            size: 3in 4in;
            margin: 0;
        }

        body,
        html {
            width: 3in;
            height: 4in;
            margin: 0;
            padding: 0;
            font-size: 10px;
        }

        main.invoice-wrapper {
            width: 3in;
            height: 4in;
            padding: 5px;
            box-sizing: border-box;
            overflow: auto;
            transform-origin: top left;
            transform: scale(0.9);
        }

        img {
            max-width: 100%;
            max-height: 0.8in;
            height: auto;
        }

        .fixed_note {
            font-size: 8px !important;
        }
    }
</style>

<body class="section-bg-one">
    <main class="container invoice-wrapper" style="padding:10px; padding-top: 0px;" id="download-section">
        <div class="content-wrapper" style="color:black">
            <div class="row">
                <div class="col-7">
                    <div class="col-7"></div>
                    <div class="conpany_ifno">
                        @if($general_setting->site_logo)
                         <img src="{{url('public/logo', $general_setting->site_logo)}}" width="40"  height="40">
                         
                        @endif
                        <p>Avijatry.com</p>
                        <p>01700000000</p>
                        <p>Gulisthan Dhaka</p>
                    </div>
                </div>
                <div class="col-5 float-end text-right">
                    <h3><strong>Invoice</strong></h3>
                    <p><strong>Invoice No: #{{ $sale->reference_no }}</strong></p>
                    <p><strong>Date:{{ date($general_setting->date_format, strtotime($sale->created_at->toDateString())) }}
                        </strong></p>
                </div>
            </div>
            <hr>
            <br>
            <div class="row">
                <div class="col-6">
                    <h2><strong>Ship To</strong> </h2>
                    <p><strong>Name:{{ $customer->name }}</strong></p>
                    <p><strong>phone:{{ $customer->phone_number }}</strong></p>
                    <p><strong>Address:{{ $delivery->address }}</strong></strong></p>

                </div>
                <div class="col-6">
                    <strong>Parcel ID:# {{ $delivery->courier_tracking_id }} </strong><br>
                    <img style="padding-bottom: 10px;padding-top:10px; width:100%; height:45px;"
                        src="data:image/png;base64,{{ DNS1D::getBarcodePNG($delivery->courier_tracking_id, 'C39') }}"
                        alt="barcode" /><br>

                 <?php echo '<img style="margin-top:10px;" src="data:image/png;base64,' . DNS2D::getBarcodePNG($delivery->courier_tracking_id, 'QRCODE') . '" alt="QRcode"   />'; ?>

                    
                    <div style="border:1px solid;margin-top:5px; padding:5px;">
                        <h3>COD:{{ $sale->grand_total }} BDT</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    Note:{{ $sale->sale_status }}
                </div>
                <div class="col-12">
                    <span class="mb-0 fixed_note">[ মার্চেন্ট এর অনুমতি ছাড়া পার্সেল ডেলিভারি করা যাবেনা। যদি কোন
                        সমস্যা হয় তাহলে +25252 নাম্বারে যোগাযোগ করবেন। ]</span>
                </div>
            </div>
        </div>

        <div class="row text-center ">
            {{-- <i class="mt-3" style="margin-top:8px;">
                Created By :34343
            </i> --}}
        </div>




    </main>
    <!-- invoice Bottom  -->
    <div class="text-center mt-5 mb-4 regular-button">
        <div class="d-print-none d-flex justify-content-center gap-10 mt-5">
            <a href="javascript:window.print()" class="btn-primary-fill">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                    <path
                        d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24"
                        fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></path>
                    <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none"
                        stroke="currentColor" stroke-linejoin="round" stroke-width="32"></rect>
                    <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none"
                        stroke="currentColor" stroke-linejoin="round" stroke-width="32"></path>
                    <circle cx="392" cy="184" r="24" fill="currentColor"></circle>
                </svg>
            </a>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>

    <!-- jquery-->
    <script src="https://www.design.linearbd.com/invoice/assets/js/jquery-3.7.0.min.js"></script>
    <!-- Plugin -->
    <script src="https://www.design.linearbd.com/invoice/assets/js/plugin.js"></script>
    <!-- Main js-->
    <script src="https://www.design.linearbd.com/invoice/assets/js/mian.js"></script>
</body>

</html>
