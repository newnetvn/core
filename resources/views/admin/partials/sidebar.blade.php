<nav class="sidebar sidebar-bunker">
    <div class="profile-element d-flex align-items-center flex-shrink-0">
        <div class="avatar online">
            <img src="{{ current_admin()->avatar }}"
                 class="img-fluid rounded-circle"
                 alt="">
        </div>
        <div class="profile-text">
            <h6 class="m-0">{{ current_admin()->name }}</h6>
            <span>{{ current_admin()->email }}</span>
        </div>
    </div><!--/.profile element-->

    <form class="search sidebar-form" action="#" method="get" >
        <div class="search__inner">
            <input type="text" class="search__text" placeholder="Search...">
            <i class="typcn typcn-zoom-outline search__helper" data-sa-action="search-close"></i>
        </div>
    </form><!--/.search-->

    <div class="sidebar-body">
        @include('core::admin.partials.admin-menu')
    </div>
</nav>
