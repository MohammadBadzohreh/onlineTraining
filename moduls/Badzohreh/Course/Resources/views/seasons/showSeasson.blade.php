<div class="table__box padding-30">
    <table class="table">
        <thead role="rowgroup">
        <tr role="row" class="title-row">
            <th class="p-r-90">شناسه</th>
            <th>عنوان فصل</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody>
        @foreach($course->seassons as $season)
            <tr role="row" class="">
                <td><a href="">1</a></td>
                <td><a href="">{{$season->title}}</a></td>
                <td>
                    <a href="" class="item-delete mlg-15" title="حذف"></a>
                    <a href="" class="item-reject mlg-15" title="رد"></a>
                    <a href="" class="item-confirm mlg-15" title="تایید"></a>
                    <a href="{{route("season.edit",$season->id)}}" class="item-edit " title="ویرایش"></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>