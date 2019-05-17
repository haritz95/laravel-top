<div class="col-md-2">
            <div class="card mb-3">
              <div class="card-header">Dashboard</div>
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link" href="{{  url('/admin/dashboard') }}" >Sites</a>
                  <a class="nav-link" href="{{ route('sites.create') }}" aria-selected="true" target="blank">New Site</a>
                  <a class="nav-link" href="{{ url('/admin/sites/categories') }}" aria-selected="true">Categories</a>
                  <div class="card-header">Users</div>
                  <a class="nav-link" href="{{  url('/admin/users') }}" aria-selected="false">Users</a>
                  <div class="card-header">Premium</div>
                  <a class="nav-link active" href="{{  url('/admin/premium') }}" aria-selected="false">Premium</a>
                  <a class="nav-link" href="{{ route('sites.create') }}" aria-selected="true" target="blank">Settings</a>
                  <div class="card-header">Ads</div>
                  <a class="nav-link" href="{{  url('/admin/ads') }}" >Ads</a>
                  <a class="nav-link" href="{{ url('/dashboard/ad/create') }}" aria-selected="true" target="blank">New Ad</a>
                  <a class="nav-link" href="{{ route('sites.create') }}" aria-selected="true" target="blank">Settings</a>
                  <div class="card-header">My Account</div>
                  <a class="nav-link" href="{{  url('/dashboard/my_account') }}" aria-selected="false">Account</a>
                  <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                  <form id="logout-form-dashboard" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                </div>
            </div>
        </div>