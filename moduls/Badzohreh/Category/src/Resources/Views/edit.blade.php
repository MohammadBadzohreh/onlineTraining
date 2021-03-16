@extends("Dashboard::master")

@section("content")
    <div class="content">
        @include("Dashboard::layouts.header")
        <div class="breadcrumb">
            <ul>
                <li><a href="index.html" title="پیشخوان">پیشخوان</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="row no-gutters">
                <div class="col-12 bg-white">
                    <p class="box__title">ایجاد دسته بندی جدید</p>
                    <form action="{{ route("categories.update",$category->id) }}" method="post" class="padding-30">
                        @method("patch")
                        @csrf
                        <input type="text" name="title" required placeholder="نام دسته بندی"
                               class="text" value="{{$category->title}}">
                        <input type="text" name="slug" required placeholder="نام انگلیسی دسته بندی"
                               class="text" value="{{$category->slug}}">
                        <p class="box__title margin-bottom-15">انتخاب دسته پدر</p>
                        <select name="parent_id">
                            <option value="">ندارد</option>
                            @foreach($categories as $categoryItem)
                                <option value="{{$categoryItem->id}}" @if($categoryItem->title == $category->parent) selected @endif>{{$categoryItem->title}}</option>
                            @endforeach

                        </select>
                        <button type="submit" class="btn btn-webamooz_net">اضافه کردن</button>
                    </form>
                </div>

            </div>
            </div>
        </div>
    </div>
@endsection