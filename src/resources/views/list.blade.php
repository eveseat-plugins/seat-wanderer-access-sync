@extends('web::layouts.app')

@section('title', trans('wanderer-access-sync::settings.title'))
@section('page_header', trans('wanderer-access-sync::settings.title'))

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('wanderer-access-sync::createMapping') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="role-sel">Select Role</label>
                    <select class="form-control" id="role-sel" name="role">
                        @foreach($seat_roles as $role)
                            <option value="{{$role->id}}">{{$role->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="wanderer-url">Wanderer URL</label>
                    <input type="text" class="form-control" id="wanderer-url" name="url">
                </div>
                <div class="form-group">
                    <label for="wanderer-acl-id">Access List ID</label>
                    <input type="text" class="form-control" id="wanderer-acl-id" name="id">
                </div>
                <div class="form-group">
                    <label for="wanderer-token">Access List Token</label>
                    <input type="text" class="form-control" id="wanderer-token" name="token">
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Wanderer URL</th>
                        <th>Access List ID</th>
                        <th>Access List Token</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{$role->role->title}}</td>
                            <td>{{$role->wanderer_url}}</td>
                            <td>{{$role->access_list_id}}</td>
                            <td>{{$role->access_list_token}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop