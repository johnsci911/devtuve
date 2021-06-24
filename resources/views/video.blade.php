
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
				@if($video->editable())
				<form action="{{ route('videos.update', $video) }}" method="POST">
                @csrf
                @method('PUT')
				@endif
					<div class="card-header">{{ $video->title }}</div>

					<div class="card-body">
						<video-js id="video" class="vjs-default-skin" controls preload="auto" width="640" height="500">
							<source src='{{ asset(Storage::url("videos/{$video->id}/{$video->id}.m3u8")) }}' type="application/x-mpegURL">
						</video-js>

						<div class="d-flex justify-content-between align-items-center">
							<div>
								<h4 class="mt-3">
                                    @if($video->editable())
                                        <input style="border: none" type="text" name="title" value="{{ $video->title }}">
                                    @else
                                        {{ $video->title }}
                                    @endif
								</h4>
							{{ $video->views }} {{ Str::of('view')->plural() }}
							</div>
                            <votes :default_votes='{{ $video->votes }}' entity_id="{{ $video->id }}" entity_owner="{{ $video->channel->user_id }}"> </votes>
						</div>
                        <hr>

                        <div>
                            @if($video->editable()) 
                            <textarea name="description" cols="3" class="form-control">{{ $video->description }}</textarea>
                            <div class="text-right">
                                <button class="mt-4 mb-4 btn btn-info btn-sm" type="submit">Update Video details</button>
                            </div>
                            @if ($errors->count())
                                <ul class="list-group">
                                    @foreach ($errors->all() as $error)
                                        <li class="list-group-item text-danger">
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            @else
                            {{ $video->description }}
                            @endif
                        </div>

						<hr>
						<div class="d-flex justify-content-between align-items-center mt-5">
							<div class="media">
								<img class="rounded-circle" src="https://picsum.photos/id/42/200/200" width="50" height="50" class="mr-3" alt="...">
								<div class="media-body ml-2">
									<h5 class="mt-0 mb-0">
										{{ $video->channel->name }} 
									</h5>
									<span class="small">Published on {{ $video->created_at->toFormattedDateString() }}</span>
								</div>
							</div>

							<subscribe-button :channel="{{ $video->channel }}" :initial-subscriptions="{{ $video->channel->subscriptions }}"/>
						</div>
					</div>
				@if ($video->editable())
				</form>
				@endif
            </div>

			<div class="card mt-5 p-5">
                <div class="media">
                    <img width="30" height="30" class="rounded-circle mr-3" src="https://picsum.photos/id/42/200/200">

                    <div class="media-body">
                        <h6 class="mt-0">Media heading</h6>
                        <small>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</small>
                        <div class="form-inline my-4 w-full">
							<input type="text" class="form-control form-control-sm w-80">
							<button class="btn btn-sm btn-primary ml-2">
								<small>Add comment</small>
							</button>
                        </div>

                        <div class="media mt-3">
                            <a class="mr-3" href="#">
                                <img width="30" height="30" class="rounded-circle mr-3" src="https://picsum.photos/id/42/200/200">
                            </a>
                            <div class="media-body">
                                <h6 class="mt-0">Media heading</h6>
                                <small >Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</small>

                                <div class="form-inline my-4 w-full">
									<input type="text" class="form-control form-control-sm w-80">
									<button class="btn btn-sm btn-primary ml-2">
										<small>Add comment</small>
									</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
	<link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet">
	<style>
		.vjs-default-skin {
			width: 100%;
		}
        .thumbs-up, .thumbs-down {
            width: 20px;
            height: 20px;
            cursor: pointer;
            fill: currentColor;
        }
        .thumbs-down-active, .thumbs-up-active {
            color: #3EA6FF;
        }
        .thumbs-down {
            margin-left: 1rem;
        }
		.w-full {
			width: 100% !important;
		}
		.w-80 {
			width: 80% !important;
		}
	</style>
@endsection

@section('scripts')
	<script src="https://vjs.zencdn.net/7.11.4/video.min.js"></script>
    <script>
        window.CURRENT_VIDEO = '{{ $video->id }}'
    </script>
	<script src="{{ asset('js/player.js') }}"></script>
@endsection
