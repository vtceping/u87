@extends("app")

@section('title',"修改id为「".$id."」的用户组")

@section('headerBtn')
    <a href="/admin/userClass" class="btn btn-primary">用户组管理</a>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card card-body" id="vue-user-edit-class">
            <form @@submit.prevent="submit">
                <h3 class="card-title">修改用户组</h3>
                <x-csrf/>
                <div class="mb-3">
                    <label class="form-label">名称</label>
                    <input type="text" class="form-control" v-model="name">
                </div>
                <div class="mb-3">
                    <label class="form-label">颜色值</label>
                    <input type="color" class="form-control form-control-color" v-model="color">
                </div>
                <div class="mb-3">
                    <label class="form-label">图标代码(svg)</label>
                    <textarea rows="3" v-model="icon" class="form-control"></textarea>
                    <small><a href="https://tabler-icons.io/">https://tabler-icons.io/</a> 、<a href="https://icons.bootcss.com/">https://icons.bootcss.com/</a> </small>
                </div>
                <div class="mb-3">
                    <label class="form-label">权限(多选)</label>
                    <select size="15" class="form-select" v-model="quanxian" multiple >
                        @foreach(Authority()->get() as $value)
                            <option value="{{$value['name']}}">{{$value['description']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">权限值</label>
                    <input type="number" class="form-control" v-model="permission_value">
                </div>
                <button class="btn btn-primary" type="submit">提交</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>var userClassId="{{ $id }}";</script>
    <script src="{{ mix("plugins/User/js/user.js") }}"></script>
@endsection