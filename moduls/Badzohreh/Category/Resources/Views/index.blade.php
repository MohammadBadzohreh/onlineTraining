@extends("Dashboard::master")
@section('content')
    <div class="content">
        <div class="header d-flex item-center bg-white width-100 border-bottom padding-12-30">
            <div class="header__right d-flex flex-grow-1 item-center">
                <span class="bars"></span>
                <a class="header__logo" href="https://webamooz.net"></a>
            </div>
            <div class="header__left d-flex flex-end item-center margin-top-2">
                <span class="account-balance font-size-12">موجودی : 2500,000 تومان</span>
                <div class="notification margin-15">
                    <a class="notification__icon"></a>
                    <div class="dropdown__notification">
                        <div class="content__notification">
                            <span class="font-size-13">موردی برای نمایش وجود ندارد</span>
                        </div>
                    </div>
                </div>
                <a href="" class="logout" title="خروج"></a>
            </div>
        </div>
        <div class="breadcrumb">
            <ul>
                <li><a href="index.html">پیشخوان</a></li>
                <li><a href="categories.html.html" class="is-active">دسته بندی ها</a></li>
            </ul>
        </div>
        <div class="main-content padding-0 categories">
            <div class="row no-gutters  ">
                <div class="col-8 margin-left-10 margin-bottom-15 border-radius-3">
                    <p class="box__title">دسته بندی ها</p>
                    <div class="table__box">
                        <table class="table">
                            <thead role="rowgroup">
                            <tr role="row" class="title-row">
                                <th>شناسه</th>
                                <th>نام دسته بندی</th>
                                <th>نام انگلیسی دسته بندی</th>
                                <th>دسته پدر</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr role="row" class="">
                                <td><a href="">1</a></td>
                                <td><a href="">برنامه نویسی</a></td>
                                <td>programming</td>
                                <td>ندارد</td>
                                <td>
                                    <a href="" class="item-delete mlg-15" title="حذف"></a>
                                    <a href="" target="_blank" class="item-eye mlg-15" title="مشاهده"></a>
                                    <a href="edit-category.html" class="item-edit " title="ویرایش"></a>
                                </td>
                            </tr>
                            <tr role="row" class="">
                                <td><a href="">1</a></td>
                                <td><a href="">وب</a></td>
                                <td>programming</td>
                                <td>وب</td>
                                <td>
                                    <a href="" class="item-delete mlg-15" title="حذف"></a>
                                    <a href="" target="_blank" class="item-eye mlg-15" title="مشاهده"></a>
                                    <a href="edit-category.html" class="item-edit " title="ویرایش"></a>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-4 bg-white">
                    <p class="box__title">ایجاد دسته بندی جدید</p>
                    <form action="" method="post" class="padding-30">
                        <input type="text" placeholder="نام دسته بندی" class="text">
                        <input type="text" placeholder="نام انگلیسی دسته بندی" class="text">
                        <p class="box__title margin-bottom-15">انتخاب دسته پدر</p>
                        <select name="" id="">
                            <option value="0">ندارد</option>
                            <option value="0">برنامه نویسی</option>
                        </select>
                        <button class="btn btn-webamooz_net">اضافه کردن</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section("js")
    <script src="js/tagsInput.js"></script>
@endsection


