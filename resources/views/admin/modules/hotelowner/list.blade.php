@extends('admin.master')

@section('content')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script> -->
<div class="app-main">
    @include('admin.partials._nav')

    <div class="app-main__outer">

        <table class="mb-0 table table-bordered">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Photo</th>
                    <th>Title</th>
                    <th>Phone number</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $counterVar = 1;
                @endphp
                @foreach ($hotelownerData as $hotelownerData)
                <tr>
                    <th>
                        @php
                        echo $counterVar;
                        @endphp
                    </th>
                    <th><img src="/images/hotel/{{$hotelownerData->photos }}" style="width: 110px; object-fit: cover; height: 100px;"></th>
                    <td>{{ $hotelownerData->title }}</td>
                    <td>{{ $hotelownerData->phone_number }}</td>
                    <td>{{ $hotelownerData->email }}</td>
                    <td>
                        <a href="{{ route('edit.owner', ['id' => $hotelownerData->id]) }}" class="btn btn-primary btn-lg" style="font-size: 1.1rem;">
                            Edit</a>
                        <a href="{{ route('delete.owner', ['id' => $hotelownerData->id]) }}" class="btn btn-danger btn-lg show_confirm " onclick="return confirm('Are you sure you want to delete this?');" style="font-size: 1.1rem;">

                            Remove</a>
                    </td>
                </tr>
                @php
                $counterVar++;
                @endphp
                @endforeach
            </tbody>
        </table>
        <div class="">
            <div class="app-wrapper-footer">
                <div class="app-footer">
                    <div class="app-footer__inner">
                        <div class="app-footer-left">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a href="javascript:void(0);" class="nav-link" style="font-size: 20px; align-content:center;">
                                        © 2024 Hamro Booking Sewa
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="app-footer-right">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection