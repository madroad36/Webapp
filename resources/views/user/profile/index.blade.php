@extends('user.layout.app')
@section('title', 'View Profile')
@section('content')

    <div class="content-wrapper" style="min-height: 1416.81px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    @if(file_exists('storage/'.$user->image) && $user->image !='')
                                        <form action="" method="post" id="sitelogo">
                                            <div class="imagePreview" style="background-image: url('{{asset('storage/'.$user->image)}}')"></div>
                                            <label class="btn btn-primary">
                                                Upload Image<input type="file" name="image" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
                                            </label>
                                        </form>
                                    @else
                                        <form action="" method="post" id="sitelogo">
                                            <div class="imagePreview"></div>
                                            <label class="btn btn-primary">
                                                Upload Image<input type="file" name="image" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
                                            </label>
                                        </form>
                                    @endif
                                    {{--<img class="profile-user-img img-fluid img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture">--}}
                                </div>

                                <h3 class="profile-username text-center">{{auth()->user()->name}}</h3>

                                <p class="text-muted text-center">{{auth()->user()->userType->name}}</p>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- About Me Box -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">About Me</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <strong><i class="fa fa-clipboard mr-1"></i> Introduction</strong>

                                <p class="text-muted">
                                   {!!  auth()->user()->description !!}
                                </p>
                                <hr>

                                <strong><i class="fa fa-user-circle-o mr-1"></i> Role</strong>
                               @if(!empty(auth()->user()->role))
                                <p class="text-muted">{{auth()->user()->roles->name}}</p>
                                @endif
                                <hr>

                                <strong><i class="fa fa-map-marker mr-1"></i> Address</strong>

                                <p class="text-muted">{{auth()->user()->location}}</p>

                                <hr>

                                <strong><i class="fa fa-phone mr-1"></i> Contact</strong>

                                <p class="text-muted">{{auth()->user()->contact}}</p>

                                <hr>

                                <strong><i class="fa fa-id-card-o mr-1"></i> ID No</strong>

                                <p class="text-muted">{{auth()->user()->batch_number}}</p>

                                <hr>

                                <strong><i class="fa fa-envelope mr-1"></i> Email</strong>

                                <p class="text-muted">{{auth()->user()->email}}</p>

                                <hr>

                                <strong><i class="fa fa-image mr-1"></i> citizenship</strong>

                                <div id="national-id">
                                    @if(file_exists('storage/'.$user->id_card) && $user->id_card !='')
                                        <form action="" method="post" id="national">
                                            <div class="imageView" style="background-image: url('{{asset('storage/'.$user->id_card)}}')"></div>
                                            <label class="btn btn-primary">
                                                Upload National Id<input type="file" name="image" class="uploadId img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
                                            </label>
                                        </form>
                                    @else
                                        <form action="" method="post" id="national">
                                            <div class="imageView"></div>
                                            <label class="btn btn-primary">
                                                Upload National Id<input type="file" name="image" class="uploadId img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
                                            </label>
                                        </form>
                                    @endif
                                </div>

                                <hr>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills" style="margin-bottom: 30px;">
                                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#edit-profile" data-toggle="tab">Edit Profile</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="activity">
                                        <!-- Post -->
                                        <div class="post">
                                            <div class="user-block">
                                                <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                                                <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                                                <span class="description">Shared publicly - 7:30 PM today</span>
                                            </div>
                                            <!-- /.user-block -->
                                            <p>
                                                Lorem ipsum represents a long-held tradition for designers,
                                                typographers and the like. Some people hate it and argue for
                                                its demise, but others ignore the hate as they create awesome
                                                tools to help create filler text for everyone from bacon lovers
                                                to Charlie Sheen fans.
                                            </p>

                                            <p>
                                                <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                                <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                                <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                                            </p>

                                            <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                                        </div>
                                        <!-- /.post -->

                                        <!-- Post -->
                                        <div class="post clearfix">
                                            <div class="user-block">
                                                <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image">
                                                <span class="username">
                          <a href="#">Sarah Ross</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                                                <span class="description">Sent you a message - 3 days ago</span>
                                            </div>
                                            <!-- /.user-block -->
                                            <p>
                                                Lorem ipsum represents a long-held tradition for designers,
                                                typographers and the like. Some people hate it and argue for
                                                its demise, but others ignore the hate as they create awesome
                                                tools to help create filler text for everyone from bacon lovers
                                                to Charlie Sheen fans.
                                            </p>

                                            <form class="form-horizontal">
                                                <div class="input-group input-group-sm mb-0">
                                                    <input class="form-control form-control-sm" placeholder="Response">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-danger">Send</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.post -->

                                        <!-- Post -->
                                        <div class="post">
                                            <div class="user-block">
                                                <img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg" alt="User Image">
                                                <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                                                <span class="description">Posted 5 photos - 5 days ago</span>
                                            </div>
                                            <!-- /.user-block -->
                                            <div class="row mb-3">
                                                <div class="col-sm-6">
                                                    <img class="img-fluid" src="../../dist/img/photo1.png" alt="Photo">
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <img class="img-fluid mb-3" src="../../dist/img/photo2.png" alt="Photo">
                                                            <img class="img-fluid" src="../../dist/img/photo3.jpg" alt="Photo">
                                                        </div>
                                                        <!-- /.col -->
                                                        <div class="col-sm-6">
                                                            <img class="img-fluid mb-3" src="../../dist/img/photo4.jpg" alt="Photo">
                                                            <img class="img-fluid" src="../../dist/img/photo1.png" alt="Photo">
                                                        </div>
                                                        <!-- /.col -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->

                                            <p>
                                                <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                                <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                                <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                                            </p>

                                            <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                                        </div>
                                        <!-- /.post -->
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="timeline">
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
                                            <!-- timeline time label -->
                                            <div class="time-label">
                        <span class="bg-danger">
                          10 Feb. 2014
                        </span>
                                            </div>
                                            <!-- /.timeline-label -->
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-envelope bg-primary"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i class="far fa-clock"></i> 12:05</span>

                                                    <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                                    <div class="timeline-body">
                                                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                                        quora plaxo ideeli hulu weebly balihoo...
                                                    </div>
                                                    <div class="timeline-footer">
                                                        <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-user bg-info"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                                                    <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                                                    </h3>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-comments bg-warning"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                                                    <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                                                    <div class="timeline-body">
                                                        Take me to your leader!
                                                        Switzerland is small and neutral!
                                                        We are more like Germany, ambitious and misunderstood!
                                                    </div>
                                                    <div class="timeline-footer">
                                                        <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                            <!-- timeline time label -->
                                            <div class="time-label">
                        <span class="bg-success">
                          3 Jan. 2014
                        </span>
                                            </div>
                                            <!-- /.timeline-label -->
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-camera bg-purple"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                                                    <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                                                    <div class="timeline-body">
                                                        <img src="http://placehold.it/150x100" alt="...">
                                                        <img src="http://placehold.it/150x100" alt="...">
                                                        <img src="http://placehold.it/150x100" alt="...">
                                                        <img src="http://placehold.it/150x100" alt="...">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                            <div>
                                                <i class="far fa-clock bg-gray"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane" id="edit-profile">
                                        {!! Form::open(array('route'=>['profile.update',auth()->user()->id],'class'=>'form-horizontal')) !!}
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="name" class="form-control" id="inputName" placeholder="Name" value="{{$user->name}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email" value="{{$user->email}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName2" class="col-sm-2 col-form-label">Address</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="address" class="form-control" id="inputName2" placeholder="Address" value="{{$user->address}}">
                                                </div>
                                            </div>
                                        <div class="form-group row">
                                            <label for="inputName2" class="col-sm-2 col-form-label">Contact</label>
                                            <div class="col-sm-10">
                                                <input type="number" name="contact" class="form-control" id="inputName2" placeholder="Contact" value="{{$user->contact}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName2" class="col-sm-2 col-form-label">UserTypes</label>
                                            <div class="col-sm-10">
                                                @php $type = [] @endphp

                                                @foreach($userTypes  as $value)

                                                    @php $type[$value->id] = $value->name @endphp
                                                @endforeach
                                                {!! Form::select('usertype_id',$type,$user->usertype_id,['class'=>'form-control','placeholder'=>'Select The User Type']) !!}

                                            </div>
                                        </div>
                                            <div class="form-group row">
                                                <label for="inputExperience" class="col-sm-2 col-form-label">Description</label>
                                                <div class="col-sm-10">
                                                    {!! Form::textarea('description',$user->description, array('class'=>'form-control editor', 'placeholder'=>'Please insert the description','id'=>'editor')) !!}

                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-danger">Submit</button>
                                                </div>
                                            </div>
                                        {!! Form::close() !!}
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- Content Wrapper. Contains page content -->

    <!-- /.content-wrapper -->


@endsection
@section('js_script')
<script>

$(function() {
$(document).on("change",".uploadFile", function()
{

    var uploadFile = $(this);
    var files = !!this.files ? this.files : [];
     if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

    if (/^image/.test( files[0].type)){ // only image file
    var reader = new FileReader(); // instance of the FileReader
    reader.readAsDataURL(files[0]); // read the local file

    reader.onloadend = function(){ // set image data as background of div
    //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
    uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
    }


        $.ajax({
            url:"{{route('profile.image')}}",
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },

            data:new FormData($("#sitelogo")[0]),
            method:"POST",
            processData: false,
            contentType: false,
            success:function(response){
                console.log(response.user);
                uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+baseUrl+"/storage/"+response.user.image+")");
            },
            error:function(error){
                console.log(error);
            }
        });
}

});
});
$(function() {
    $(document).on("change",".uploadId", function()
    {

        var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file

            reader.onloadend = function(){ // set image data as background of div
                //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                uploadFile.closest("#national-id").find('.imageView').css("background-image", "url("+this.result+")");
            }


            $.ajax({
                url:"{{route('profile.nationalId')}}",
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },

                data:new FormData($("#national")[0]),
                method:"POST",
                processData: false,
                contentType: false,
                success:function(response){
                    console.log(response.user);
                    uploadFile.closest("#national-id").find('.imageView').css("background-image", "url("+baseUrl+"/storage/"+response.user.id_card+")");
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

    });
});
</script>
@endsection