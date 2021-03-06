@extends('frontend.layouts.auth')

@section('page-title', trans('app.sign_up'))

@section('content')
        <p class="login-box-msg">Register a new membership</p>
        <form role="form" action="<?=url('register')?>" method="post" id="registration-form" autocomplete="off">
            <input type="hidden" value="<?=csrf_token()?>" name="_token">

            <div class="form-group has-feedback">
                <input type="email" name="email" id="email" class="form-control" placeholder="@lang('app.email')" value="{{ old('email') }}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <input type="text" name="username" id="username" class="form-control" placeholder="@lang('app.username')"  value="{{ old('username') }}">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Nome"  value="{{ old('first_name') }}">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Sobrenome"  value="{{ old('last_name') }}">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <input type="password" name="password" id="password" class="form-control" placeholder="@lang('app.password')">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="@lang('app.confirm_password')">
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>

            @if (Setting::get('registration.captcha.enabled'))
                <div class="form-group has-feedback">
                    {!! app('captcha')->display() !!}
                </div>
            @endif

            <div class="row">
                <div class="col-xs-8">
                @if (Setting::get('tos'))
                  <div class="checkbox icheck">
                    <label>
                      <input type="checkbox" name="tos" id="tos"> @lang('app.i_accept') <a href="#tos-modal" data-toggle="modal">@lang('app.terms_of_service')</a>
                    </label>
                  </div>
                @endif
                </div>
                <div class="col-xs-4">
                  <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div>
            </div>

            @include('frontend.auth.social.buttons')
        </form>

    </div>

    @if (Setting::get('tos'))
        <div class="modal fade" id="tos-modal" tabindex="-1" role="dialog" aria-labelledby="tos-label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="@lang('app.terms_of_service')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title" id="tos-label">@lang('app.terms_of_service')</h3>
                    </div>
                    <div class="modal-body">
                        <h4>1. Terms</h4>

                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Donec quis lacus porttitor, dignissim nibh sit amet, fermentum felis.
                            Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere
                            cubilia Curae; In ultricies consectetur viverra. Nullam velit neque,
                            placerat condimentum tempus tincidunt, placerat eu lectus. Nam molestie
                            porta purus, et pretium risus vehicula in. Cras sem ipsum, varius sagittis
                            rhoncus nec, dictum maximus diam. Duis ac laoreet est. In turpis velit, placerat
                            eget nisi vitae, dignissim tristique nisl. Curabitur sollicitudin, nunc ut
                            viverra interdum, lacus...
                        </p>

                        <h4>2. Use License</h4>

                        <ol type="a">
                            <li>
                                Aenean vehicula erat eu nisi scelerisque, a mattis purus blandit. Curabitur congue
                                ollis nisl malesuada egestas. Lorem ipsum dolor sit amet, consectetur adipiscing elit:
                            </li>
                        </ol>

                        <p>...</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

@stop

@section('after-scripts-end')
    {!! JsValidator::formRequest('App\Http\Requests\Auth\RegisterRequest', '#registration-form') !!}
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
@stop