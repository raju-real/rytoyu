<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                Seller Info
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <tr>
                            <th class="w-25">Status</th>
                            <td>{{ ucFirst($seller->status) ?? '' }}</td>
                            <th class="w-25">Code</th>
                            <td>{{ $seller->code ?? '' }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">Name</th>
                            <td>{{ $seller->name ?? '' }}</td>
                            <th class="w-25">Mobile</th>
                            <td>{{ $seller->mobile ?? '' }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">Email</th>
                            <td>{{ $seller->email ?? '' }}</td>
                            <th class="w-25">Commission Rate</th>
                            <td>{{ $seller->commission_rate ?? '' }} %</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                Shop Info
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <tr>
                            <th style="width: 150px;">Shop Name</th>
                            <td>{{ $seller->shop->shop_name ?? '' }}</td>
                            <th style="width: 150px;">Mobile</th>
                            <td>{{ $seller->shop->mobile ?? '' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 150px;">Phone</th>
                            <td>{{ $seller->shop->phone ?? '' }}</td>
                            <th style="width: 150px;">Email</th>
                            <td>{{ $seller->shop->email ?? '' }}</td>
                        </tr>
                       <tr>
                            
                            <th style="width: 150px;">Address</th>
                            <td>{{ $seller->shop->address ?? '' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

