<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('survey-step') }}'><i class='nav-icon las la-shoe-prints'></i> Survey steps</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('input-type') }}'><i class='nav-icon las la-pencil-ruler'></i> Input types</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('survey-item') }}'><i class='nav-icon las la-sitemap'></i> Survey items</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('survey') }}'><i class='nav-icon las la-poll'></i> Surveys</a></li>
<li class='nav-item d-none'><a class='nav-link' href='{{ backpack_url('survey-history') }}'><i class='nav-icon la la-question'></i> Survey histories</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('user-survey') }}'><i class='nav-icon las la-poll-h'></i> User surveys</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon la la-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
