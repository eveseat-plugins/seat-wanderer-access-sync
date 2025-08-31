@extends('web::layouts.app')

@section('title', trans('wanderer-access-sync::settings.title'))
@section('page_header', trans('wanderer-access-sync::settings.title'))

@section('content')
    <div class="card">
        <div class="card-body">
            <h5>Create Role Mapping</h5>
            <form action="{{ route('wanderer-access-sync::createMapping') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="role-sel">Select SeAT Role</label>
                    <select class="form-control" id="role-sel" name="role">
                        @foreach($seat_roles as $role)
                            <option value="{{$role->id}}">{{$role->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="role-sel">Select Wanderer Access List</label>
                    <select class="form-control" id="acl-sel" name="acl">
                        @foreach($wanderer_access_lists as $list)
                            <option value="{{$list->id}}">{{$list->access_list_id}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5>Role Mapping</h5>
            <table class="table">
                <thead>
                <tr>
                    <th>Role</th>
                    <th>Wanderer Access List</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{$role->role->title}}</td>
                        <td>{{$role->accessList->access_list_id}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <h5>Wanderer Access Lists</h5>

            <form action="{{ route('wanderer-access-sync::createWandererAccessList') }}" method="POST">
                @csrf
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
            <h5>Wanderer Access Lists</h5>
            <table class="table">
                <thead>
                <tr>
                    <th>Wanderer URL</th>
                    <th>Access List ID</th>
                    <th>Access List Token</th>
                </tr>
                </thead>
                <tbody>
                @foreach($wanderer_access_lists as $access_list)
                    <tr>
                        <td>{{$access_list->wanderer_url}}</td>
                        <td>{{$access_list->access_list_id}}</td>
                        <td>{{$access_list->access_list_token}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop