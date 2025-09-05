@extends('web::layouts.app')

@section('title', trans('wanderer-access-sync::settings.title'))
@section('page_header', trans('wanderer-access-sync::settings.title'))

@section('content')
    <div class="card">
        <div class="card-body">
            <h5>{{trans('wanderer-access-sync::settings.create_role_mapping')}}</h5>
            <form action="{{ route('wanderer-access-sync::createMapping') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="role-sel">{{trans('wanderer-access-sync::settings.select_seat_role')}}</label>
                    <select class="form-control" id="role-sel" name="role">
                        @foreach($seat_roles as $role)
                            <option value="{{$role->id}}">{{$role->title}}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">{{trans('wanderer-access-sync::settings.help_mapping_role')}}</small>
                </div>
                <div class="form-group">
                    <label for="role-sel">{{trans('wanderer-access-sync::settings.select_access_list')}}</label>
                    <select class="form-control" id="acl-sel" name="acl">
                        @foreach($wanderer_access_lists as $list)
                            <option value="{{$list->id}}">{{$list->access_list_id}}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">{{trans('wanderer-access-sync::settings.help_mapping_list')}}</small>
                </div>
                <button type="submit" class="btn btn-primary">{{trans('wanderer-access-sync::settings.add')}}</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5>{{ trans('wanderer-access-sync::settings.role_mapping') }}</h5>
            <table class="table">
                <thead>
                <tr>
                    <th>{{ trans('wanderer-access-sync::settings.role') }}</th>
                    <th>{{trans_choice('wanderer-access-sync::settings.wanderer_access_list',1)}}</th>
                    <th>{{ trans('wanderer-access-sync::settings.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{$role->role->title}}</td>
                        <td>{{$role->accessList->access_list_id}}</td>
                        <td class="text-right">
                            <form method="POST" action="{{ route('wanderer-access-sync::deleteMapping') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $role->id }}">
                                <button class="btn btn-danger btn-sm confirmdelete" type="submit">{{trans('wanderer-access-sync::settings.delete')}}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5>{{trans_choice('wanderer-access-sync::settings.wanderer_access_list',2)}}</h5>

            <form action="{{ route('wanderer-access-sync::createWandererAccessList') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="wanderer-url">{{trans('wanderer-access-sync::settings.wanderer_url')}}</label>
                    <input type="text" class="form-control" id="wanderer-url" name="url" placeholder="{{trans('wanderer-access-sync::settings.wanderer_url_placeholder')}}">
                </div>
                <div class="form-group">
                    <label for="wanderer-acl-id">{{trans('wanderer-access-sync::settings.access_list_id')}}</label>
                    <input type="text" class="form-control" id="wanderer-acl-id" name="id" placeholder="{{trans('wanderer-access-sync::settings.access_list_id_placeholder')}}">
                </div>
                <div class="form-group">
                    <label for="wanderer-token">{{trans('wanderer-access-sync::settings.access_list_token')}}</label>
                    <input type="text" class="form-control" id="wanderer-token" name="token" placeholder="{{trans('wanderer-access-sync::settings.access_list_token_placeholder')}}">
                </div>
                <button type="submit" class="btn btn-primary">{{trans('wanderer-access-sync::settings.add')}}</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5>{{trans_choice('wanderer-access-sync::settings.wanderer_access_list',2)}}</h5>
            <table class="table">
                <thead>
                <tr>
                    <th>{{trans('wanderer-access-sync::settings.wanderer_url')}}</th>
                    <th>{{trans('wanderer-access-sync::settings.access_list_id')}}</th>
                    <th>{{trans('wanderer-access-sync::settings.access_list_token')}}</th>
                    <th>{{ trans('wanderer-access-sync::settings.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($wanderer_access_lists as $access_list)
                    <tr>
                        <td>{{$access_list->wanderer_url}}</td>
                        <td>{{$access_list->access_list_id}}</td>
                        <td>{{$access_list->access_list_token}}</td>
                        <td class="text-right">
                            <form method="POST" action="{{ route('wanderer-access-sync::deleteInstance') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $access_list->id }}">
                                <button class="btn btn-danger btn-sm confirmdelete" type="submit">{{trans('wanderer-access-sync::settings.delete')}}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop