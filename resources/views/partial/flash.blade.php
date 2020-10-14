
     

         @if(Session::has('message'))
                           <div class="alert alert-{{session('alert-type')}} alert-success fade show text-center"  id="session-alert"  role="alert">
                              <strong> {{Session::get('message')}}</strong>   
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                @endif


<!--
         @if(Session::has('message'))
                           <div class="alert alert-{{session('alert-type')}} alert-success fade show text-center"  id="session-alert"  role="alert">
                              <strong> {{Session::get('message')}}</strong>   
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                @endif

                   @if(Session('session'))
        <div class="alert alert-{{session('alert-type')}} alert-dismissible fade show" role="alert" id="session-alert">
         {{ Session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
            </button>
            </div>
         @endif
                 -->
