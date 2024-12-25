<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li><a class="ai-icon" href="{{ route('admin.home') }}" aria-expanded="false">
                    <i class="la la-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li><a href="{{ url('admin/settings') }}" aria-expanded="false">
                    <i class="la la-file-text"></i>
                    <span class="nav-text">Setting</span>
                </a>
            </li>
            <li><a class="ai-icon" href="{{ url('admin/quote') }}" aria-expanded="false">
                    <i class="la la-calendar"></i>
                    <span class="nav-text">Quote</span>
                </a>
            </li>
            <li><a class="ai-icon" href="{{ url('admin/help-and-feedback') }}" aria-expanded="false">
                    <i class="la la-calendar"></i>
                    <span class="nav-text">Help & Feedback</span>
                </a>
            </li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="la la-th-list"></i>
                    <span class="nav-text">Content</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ url('admin/content/edit/pp')}}">Privacy Policy</a></li>
                    <li><a href="{{ url('admin/content/edit/tc')}}">Terms & Conditions</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="la la-th-list"></i>
                    <span class="nav-text">Forms</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ url('admin/executive')}}">Executive Leaders</a></li>
                </ul>
                <ul aria-expanded="false">
                    <li><a href="{{ url('admin/my-right')}}">My Right</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="la la-th-list"></i>
                    <span class="nav-text">Pages</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ url('admin/white-house-detail')}}">White House Detail</a></li>
                    <li><a href="{{ url('admin/congress-detail')}}">Congress Detail</a></li>
                    <li><a href="{{ url('admin/house-representative-detail')}}">House Detail</a></li>
                    <li><a href="{{ url('admin/senate-detail')}}">Senate Detail</a></li>
                    <li><a href="{{ url('admin/bill-of-right-detail')}}">Bill Of Right Detail</a></li>

                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="la la-th-list"></i>
                    <span class="nav-text">Get Data Form</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ url('admin/congress/member')}}">Congress Member</a></li>
                </ul>
                <ul aria-expanded="false">
                    <li><a href="{{ url('admin/congress/bills')}}">Congress Bills</a></li>
                </ul>
                <ul aria-expanded="false">
                    <li><a href="{{ url('admin/national-debt-budget')}}">National Debt</a></li>
                </ul>
                <ul aria-expanded="false">
                    <li><a href="{{ url('admin/executive-orders')}}">Executive Orders</a></li>
                </ul>
                <ul aria-expanded="false">
                    <li><a href="{{ url('admin/spending-data')}}">Spending Data</a></li>
                </ul>
            </li>

            <li><a class="ai-icon" href="{{ url('admin/notification') }}" aria-expanded="false">
                    <i class="la la-calendar"></i>
                    <span class="nav-text">Notification</span>
                </a>
            </li>
           
        </ul>
    </div>
</div>