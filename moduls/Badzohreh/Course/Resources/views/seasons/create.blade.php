<p class="box__title">سرفصل ها</p>
<form action="{{route("seassons.store",$course->id)}}" method="post" class="padding-30">
    @csrf
    <x-input type="text" name="title" placeholder="عنوان سرفصل" class="text" />
    <x-input type="text" name="number" placeholder="شماره سرفصل" class="text" />
    <button class="btn btn-webamooz_net">اضافه کردن</button>
</form>