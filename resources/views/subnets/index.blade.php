@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="card pt-4 pb-4 col-12">

                <form action="/subnet" method="post">

                    @csrf

                    <div class="row">
                        <span hidden id="id_subnet_ip">{{  isset($subnet_ip) ? $subnet_ip : '' }}</span>
                        <div class="col-sm-4 col-8">
                            <div class="form-group">
                                <input
                                    type="text" class="form-control"
                                    id="ip" name="ip"
                                    value="{{ isset($ip) ? $ip : '' }}"
                                    placeholder="ip address" required/>
                            </div>
                        </div>

                        <div class="col-1 text-center">
                            <b>/</b>
                        </div>

                        <div class="col-sm-4 col-3">
                            <div class="form-group">
                                <input
                                    type="text" class="form-control"
                                    id="cidr_size" name="cidr_size"
                                    value="{{ isset($cidr_size) ? $cidr_size : '' }}"
                                    placeholder="cidr size" required/>
                            </div>
                        </div>

                        <div class="col-sm-2 col-12">
                            <div class="form-group">
                                <button class="btn btn-dark btn-block">Search</button>
                            </div>
                        </div>

                    </div>

                </form>

            </div>

            <div class="card mt-4 p-4 col-12 overflow-auto">

                <div class="row">

                    <div class="container">

                        <div v-if="this.ips.length">

                            <div class="col-12">
                                <ips-component :ips="this.ips"/>
                            </div>

                            <div class="col-4 mt-4 p-2">
                                <button class="btn btn-outline-dark" @click="load()">
                                    Load more
                                </button>
                            </div>

                        </div>

                        <div v-else>
                            <h3 class="text-center text-secondary">
                                Empty
                            </h3>
                        </div>

                    </div>

                </div>


            </div>
        </div>

    </div>
@endsection
