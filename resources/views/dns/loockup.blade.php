@extends('layouts.app')

@section('content')
    <div class="container">

       <div class="row">

           <div class="card p-4 col-12">

               <form action="/dns/loockup" method="get">

                   <div class="row">

                       <div class="col-md-10 col-sm-8">
                           <div class="form-group">
                               <input
                                   type="text" class="form-control"
                                   id="domainName" name="domainName"
                                   value="{{ request('domainName') ? preg_replace('/((https:\/\/)|(http:\/\/)|\/.*)/', '', \request('domainName')) : '' }}"
                                   placeholder="example.com" required />
                           </div>
                       </div>

                       <div class="col-md-2 col-sm-4">
                           <div class="form-group">
                               <button class="btn btn-dark btn-block">Search</button>
                           </div>
                       </div>

                   </div>

               </form>

           </div>

           @foreach($results as $key => $result)

               <div class="card p-4 mt-4 col-12 overflow-auto">

                   <div class="card-header">

                       <h5 style="text-transform: uppercase">

                           {{ $result[0]['type'] }}

                       </h5>

                   </div>

                   <div class="card-body">

                       <div class="p-4">

                           <table class="table table-bordered">
                               <thead>

                               @foreach($result[0] as $sub_key => $sub_result)

                                   <th>
                                       {{ $sub_key }}
                                   </th>

                               @endforeach

                               </thead>

                               <tbody>

                               @foreach($result as $sub_key => $sub_result)

                                   <tr>

                                       @foreach($sub_result as $sub_level2_result)

                                           <td>

                                               <?php
                                               try {
                                                   echo $sub_level2_result;

                                               } catch (Exception $e) {
                                                   echo "";
                                               }
                                               ?>

                                           </td>

                                       @endforeach

                                   </tr>

                               @endforeach

                               </tbody>

                           </table>

                       </div>

                   </div>

               </div>

           @endforeach

       </div>

    </div>
@endsection
