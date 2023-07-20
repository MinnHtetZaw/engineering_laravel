<div class="card">
    <div class="card-body">

    <div class="col-12">
    <div>
       <h3 style=" text-align : center;color : secondary;font-weight : bold;">{{$title}}</h3>
    </div>
    <p>{{$body}}</p>
    </div>
    <table class="table table-striped" style=" width: 100%;height: auto;margin-top: 20px;border-radius: 20px;border: 1px solid rgba(2,127,157,1);">
        <thead>
        <tr class="fw-normal text-white text-center">
        <th>No</th>
        <th>Name</th>
        <th>Brand</th>
        <th>Order Qty</th>
        <th>Order Price</th>
        <th>Required Specs</th>
        <?php $i = 1;$total_amount = 0;$total_qty=0;?>
        </tr>
        </thead>
        <tbody>
        @if ($type == 2)
        @foreach ($products as $pre)
        <tr class="fw-normal text-center">
        <td>{{$i++}}</td>
        <td>{{$pre['product']['product_name']}}</td>
        <td>{{$pre['product']['brand']['brand_name']}}</td>
        <td>{{$pre['requested_qty']}}</td>
        <td>{{$pre['requested_price']}}</td>
        <td>
          {{$pre['requested_specs']}}
        </td>
     <?php $total_amount += $pre['requested_qty']*$pre['requested_price']; $total_qty += $pre['requested_qty'];  ?>
        </tr>
     @endforeach
     @elseif ($type == 4)
     @foreach ($products as $pre)
     <tr class="fw-normal text-center">
     <td>{{$i++}}</td>
     <td>{{$pre['product']['product_name']}}</td>
     <td>{{$pre['product']['brand']['brand_name']}}</td>
     <td>{{$pre['required_qty']}}</td>
     <td>{{$pre['required_price']}}</td>
     <td>
       {{$pre['required_spec']}}
     </td>
  <?php $total_amount += $pre['required_qty']*$pre['required_price']; $total_qty += $pre['required_qty'];  ?>
     </tr>
  @endforeach
        @endif

        </tbody>
    </table>
  <div class="row">
    <div class="col-6 mt-3">
        <span style="float :left;color : secondary;margin-top:20px;">Total Quantity : {{$total_qty}}</span>
    </div>
    <div class="col-6 mt-3">
        <span style=" float : right;color : secondary;margin-top:20px;">Total Amount : {{$total_amount}}</span>
    </div>

    </div>
     </table>
    </div>
    </div>

