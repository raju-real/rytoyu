<ul>
    <li class="{{ request()->segment(1) === 'user-profile' ? 'active' : '' }}">
        <a href="{{ route('user-profile') }}"> Profile </a>
    </li>
    <li><a href="{{ route('change-password') }}">Change Password</a></li>
    <li class="{{ in_array(request()->segment(1), ['order-list', 'order-details']) ? 'active' : '' }}">
        <a href="{{ route('order-list') }}">Order List</a>
    </li>
    <li><a href="order-status.html">Order Status</a></li>
    <li><a href="review-rating.html">Reviews and Ratings</a></li>
    <li><a href="return.html">Returns Requests</a></li>

</ul>
