<ul class="list-unstyled clearfix boxMenuList" data-dragli="menu">
    @foreach($data as $menu)
        <li data-name="{!! $menu['title'] !!}" data-id="{!! $menu['id'] !!}">
            <a href="#">
                <img src="/public/img/menu.png" alt="">
                <span>{!! $menu['title'] !!}</span>

            </a>
            <div class="hide" data-content="{!! $menu['id'] !!}">{!! $menu['html_data'] !!}
                <style>{!! $menu['cssc_lass'] !!}</style>
            </div>
            <div class="hide" data-json="{!! $menu['id'] !!}">{!! $menu['json_data'] !!}</div>

        </li>
    @endforeach
</ul>