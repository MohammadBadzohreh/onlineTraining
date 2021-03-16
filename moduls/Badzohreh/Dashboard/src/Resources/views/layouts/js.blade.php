<script src="/panel/js/jquery-3.4.1.min.js"></script>
<script src="/panel/js/js.js?v={{ uniqid() }}"></script>
<script src="/panel/js/jquery.toast.min.js"></script>
@if(session()->has("feedbacks"))
    <script>
        $.toast({
            heading: {{ session()->get("feedbacks")["title"] }} ,
            text: {{ session()->get("feedbacks")["body"] }},
            showHideTransition: 'slide',
            bgColor: 'blue',              // Background color for toast
            textColor: '#eee',            // text color
            allowToastClose: false,       // Show the close button or not
            hideAfter: 5000,              // `false` to make it sticky or time in miliseconds to hide after
            stack: 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
            textAlign: 'left',            // Alignment of text i.e. left, right, center
            position: 'bottom-left',
        })
    </script>
@endif
@yield('js')

