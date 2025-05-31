<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: rgb(55, 55, 55);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            margin: auto;
            box-sizing: border-box;
            padding-bottom: 300px; /* Space for footer */
        }

        .section {
            padding: 0px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 8px 4px;
            text-align: left;
        }

        .bottom-box {

            width: 100%;
            page-break-inside: avoid; /* Prevent footer from breaking across pages */
        }

        /* For print media */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            
            .container {
                padding-bottom: 0;
            }
            
            .bottom-box {
                position: fixed;
                bottom: 0;
            }
            
            /* Ensure items table breaks properly across pages */
            .items-table tbody tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="section">
            <table class="table">
                <tr>
                    <td style="width: 60%;vertical-align: top;border: none">
                        <img src="http://local-dev.test/rytoyu/assets/files/images/settings/1744602253-logo.png"
                            alt="" width="150px">
                        <table class="table">
                            <tr>
                                <td style="width: 50%; vertical-align: top; text-align: left;border: none;">
                                    <strong style="font-size: 20px; color: balck;">Invoice To</strong><br>
                                    <p style="font-size: 14px;color: black;line-height: 20px;">
                                        {{ $order->customer_full_name ?? '' }}<br>
                                        <span style="font-weight: bold;">{{ $order->mobile ?? '' }}</span><br>
                                        {{ $order->city_town ?? '' }} {{ $order->post_code ?? '' }}<br>
                                        {{ $order->address ?? '' }}<br>
                                        {{ 'Bangladesh' }}
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 40%;border: none;text-align: left;">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td style="border: none;padding: 2px 4px;">Invoice No.</td>
                                    <td style="border: none;padding: 2px 4px;">:</td>
                                    <td style="border: none;padding: 2px 4px;">{{ $order->invoice ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td style="border: none;padding: 2px 4px;">Invoice Date</td>
                                    <td style="border: none;padding: 2px 4px;">:</td>
                                    <td style="border: none;padding: 2px 4px;">
                                        {{ date('d M, Y', strtotime($order->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <td style="border: none;padding: 2px 4px;">Order No.</td>
                                    <td style="border: none;padding: 2px 4px;">:</td>
                                    <td style="border: none;padding: 2px 4px;">{{ $order->order_number ?? '' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="table items-table" style="margin-top: 10px;">
                <thead>
                    <tr style="background-color: #000000">
                        <th style="color: white;text-align: left;padding-left: 3px;">SKU</th>
                        <th style="color: white;text-align: left;padding-left: 3px;">Name</th>
                        <th style="color: white;text-align: center;">Item price</th>
                        <th style="color: white;text-align: center;">Qty</th>
                        <th style="color: white;text-align: center;">Item Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->order_products as $order_product)
                        <tr>
                            <td style="text-align: left;padding-left: 3px;">
                                {{ $order_product->product->product_code ?? '' }}</td>
                            <td style="text-align: left;padding-left: 3px;">{{ $order_product->product->name ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $order_product->item_order_price ?? '' }}</td>
                            <td style="text-align: center;">{{ $order_product->quantity ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $order_product->item_total_order_price }} BDT</td>
                        </tr>
                        <tr>
                            <td style="text-align: left;padding-left: 3px;">
                                {{ $order_product->product->product_code ?? '' }}</td>
                            <td style="text-align: left;padding-left: 3px;">{{ $order_product->product->name ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $order_product->item_order_price ?? '' }}</td>
                            <td style="text-align: center;">{{ $order_product->quantity ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $order_product->item_total_order_price }} BDT</td>
                        </tr>
                        <tr>
                            <td style="text-align: left;padding-left: 3px;">
                                {{ $order_product->product->product_code ?? '' }}</td>
                            <td style="text-align: left;padding-left: 3px;">{{ $order_product->product->name ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $order_product->item_order_price ?? '' }}</td>
                            <td style="text-align: center;">{{ $order_product->quantity ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $order_product->item_total_order_price }} BDT</td>
                        </tr>
                        <tr>
                            <td style="text-align: left;padding-left: 3px;">
                                {{ $order_product->product->product_code ?? '' }}</td>
                            <td style="text-align: left;padding-left: 3px;">{{ $order_product->product->name ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $order_product->item_order_price ?? '' }}</td>
                            <td style="text-align: center;">{{ $order_product->quantity ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $order_product->item_total_order_price }} BDT</td>
                        </tr>
                        <tr>
                            <td style="text-align: left;padding-left: 3px;">
                                {{ $order_product->product->product_code ?? '' }}</td>
                            <td style="text-align: left;padding-left: 3px;">{{ $order_product->product->name ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $order_product->item_order_price ?? '' }}</td>
                            <td style="text-align: center;">{{ $order_product->quantity ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $order_product->item_total_order_price }} BDT</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="charge-box">
            <table class="table" style="margin-top: 30px;">
                <thead>
                    <tr style="background-color: #000000">
                        <th style="color: white;text-align: center;">Net amount</th>
                        <th style="color: white;text-align: center;">Vat</th>
                        <th style="color: white;text-align: center;">Shipping Fee</th>
                        <th style="color: white;text-align: center;">Service Charge</th>
                        <th style="color: white;text-align: center;">Coupon</th>
                        <th style="color: white;text-align: center;">Coupon Discount</th>
                        <th style="color: white;text-align: center;">Total amount BDT</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">{{ numberFormat($order->total_item_order_price, 2) ?? 0.0 }}
                        </td>
                        <td style="text-align: center;">{{ $order->total_vat ?? 0.0 }}</td>
                        <td style="text-align: center;">{{ $order->shipping_fee ?? 0.0 }}</td>
                        <td style="text-align: center;">{{ $order->service_charge ?? 0.0 }}</td>
                        <td style="text-align: center;">{{ $order->coupon_code ?? 'N/A' }}</td>
                        <td style="text-align: center;">{{ $order->coupon_discount_amount ?? 0.00 }}</td>
                        <td style="text-align: center;">{{ $order->total_order_price ?? 0.0 }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="comment-box">
            <p>Comment: {{ $order->comment ?? '' }}</p>
        </div>

    <div class="bottom-box">
        
        <div class="message-box" style="margin-top: 20px;">
            <small style="font-size: 13px;">In case of late payment, 8% interest per started month and a reminder fee of
                BDT 100. Bagela AB (Tellecto) delivery and payment condition apply for shipping.</small>
        </div>
        <table class="table" style="margin-top: 10px;">
            <thead>
                <tr style="background-color: #000000">
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tr>
                <td style="border: none; padding: 5px"></td>
            </tr>
            <tbody>
                <tr>
                    <td style="width: 33%; text-align: left;border-right: 2px solid #000000">
                        <p style="color: #000000;font-size: 13px;">Bagela AB (Tellecto)</p>
                        <span style="color: #000000">Adress:</span> Skeppsgatan 19<br>
                        211 11 Malmö | Sweden<br>
                        F-Tax Registered <br>
                        faktura@tellecto.se<br>
                    </td>
                    <td style="width: 33%; text-align: left;border-right: 2px solid #000000">
                        <p style="color: #000000;font-size: 13px;">Payment Info</p>
                        <span style="color: #000000">Bankgiro: </span> 330-2478<br>
                        <span style="color: #000000">IBAN:</span> SE72 6000 0000 0007 1268 8412 <br>
                        <span style="color: #000000">BIC:</span> HANDSESS <br>
                        <span style="color: #000000">VAT. No:</span> SE559453730901
                    </td>
                    <td style="width: 33%; text-align: left;">
                        <p style="color: #000000;font-size: 13px;">Contact</p>
                        <span style="color: #000000">Email:</span> faktura@tellecto.se<br>
                        <span style="color: #000000">Telefon:</span> 0762164706<br>
                        <span style="color: #000000">Office Hour:</span> Mån-fre 08:00 - 17:00
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>