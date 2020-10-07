<div class="table__box padding-30">
    <table class="table">
        <thead role="rowgroup">
        <tr role="row" class="title-row">
            <th class="p-r-90">شناسه</th>
            <th>عنوان فصل</th>
            <th>وضعیت سرفصل</th>
            <th>حالت سرفصل</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody>
        @foreach($course->seassons as $season)
            <tr role="row" class="">
                <td><a href="">1</a></td>
                <td><a href="">{{$season->title}}</a></td>
                <td><a href="" class="confirmation_status">@lang($season->confirmation_status)</a></td>
                <td><a href="" class="status">@lang($season->status)</a></td>
                <td>

                    @can(\Badzohreh\RolePermissions\Models\Permission::PERMISSION_MANAGE_COURSES)
                        <a href="" class="item-delete mlg-15" title="حذف"></a>
                        <a href="" class="item-reject mlg-15" title="رد"
                           onclick="handleChangeStatus(event,'{{route("season.reject",$season->id)}}','ایا مطمئن هستید؟','رد شده')"
                        ></a>
                        <a href="" class="item-confirm mlg-15" title="تایید"
                           onclick="handleChangeStatus(event,'{{route("season.accpet",$season->id)}}','ایا مطمئن هستید؟','تایید شده')"></a>



                        <a href="" class="item-lock mlg-15 text-error" title="قفل"
                           onclick="handleChangeStatus(event,'{{route("season.closed",$season->id)}}','ایا مطمئن هستید؟','قفل شده')"></a>


                        <a href="" class="item-lock mlg-15 text-success" title="باز"
                           onclick="handleChangeStatus(event,'{{route("season.opened",$season->id)}}','ایا مطمئن هستید؟','باز')"></a>
                    @endcan


                    <a href="{{route("season.edit",$season->id)}}" class="item-edit " title="ویرایش"></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>