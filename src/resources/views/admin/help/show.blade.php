@extends ('layouts.admin-default')

@section ('page_title', 'Help')

@section ('content')

<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom">Help - {{ $helpCategory->name }}</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="/admin/help">Help</a>
			</li>
			<li class="breadcrumb-item active">
				{{ $helpCategory->name }}
			</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-lg-8">

		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-entry fa-fw"></i> Entrys
			</div>
			<div class="card-body">
				<div class="dataTable_wrapper">
					<table width="100%" class="table table-striped table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>Name</th>
								<th>Content</th>
								<th>Added</th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($entrys as $entry)
								<tr>
									{{ Form::open(array('url'=>'/admin/help/' . $helpCategory->slug . '/' . $entry->id, 'files' => true )) }}
										<td>
											<div class="mb-3">
												{{ Form::text('name', $entry->display_name,array('id'=>'name','class'=>'form-control')) }}
											</div>
										</td>
										<td>
											<div class="mb-3">
												{{ Form::textarea('content', $entry->content,array('id'=>'content','class'=>'form-control wysiwyg-editor-small', 'rows'=>'2')) }}
											</div>
										</td>
										<td>
											{{ $entry->created_at }}
										</td>
										<td width="15%">
											<button type="submit" class="btn btn-primary btn-sm btn-block">Update</button>
												{{ Form::close() }}
												<button
												class="btn btn-primary btn-sm btn-block"
											 data-bs-toggle="modal"
											 data-bs-target="#attachmentManagerModal{{$entry->id}}"
											>
												@lang('help.showattachmentmanager')
											</button>
										</td>
									<td width="15%">
										{{ Form::open(array('url'=>'/admin/help/' . $helpCategory->slug . '/' . $entry->id, 'files' => true, 'onsubmit' => 'return ConfirmDelete()')) }}
										{{ Form::hidden('_method', 'DELETE') }}
											<button type="submit" class="btn btn-danger btn-sm btn-block">Delete</button>
										{{ Form::close() }}
									</td>
								</tr>								
							@endforeach
						</tbody>
					</table>
					{{ $entrys->links() }}
				</div>
				<!-- /.table-responsive -->
			</div>
		</div>

	</div>
	<div class="col-lg-4">

		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-upload fa-fw"></i> Add Entry
			</div>
			<div class="card-body">
				{{ Form::open(array('url'=>'/admin/help/' . $helpCategory->slug . '/add',)) }}
					<div class="mb-3">
						{{ Form::label('name','Entry Name',array('id'=>'','class'=>'')) }}
						{{ Form::text('name', NULL ,array('id'=>'name','class'=>'form-control')) }}
					</div>
					<div class="mb-3">
						{{ Form::label('content','Entry Content',array('id'=>'','class'=>'')) }}
						{{ Form::textarea('content', NULL ,array('id'=>'content','class'=>'form-control wysiwyg-editor', 'rows'=>'2')) }}
					</div>
					<button type="submit" class="btn btn-primary btn-block">Add</button>
				{{ Form::close() }}
			</div>
		</div>
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-wrench fa-fw"></i> Settings
			</div>
			<div class="card-body">
				<div class="list-group">
					{{ Form::open(array('url'=>'/admin/help/' . $helpCategory->slug)) }}
						<div class="mb-3">
							{{ Form::label('name','Album Name',array('id'=>'','class'=>'')) }}
							{{ Form::text('name',$helpCategory->name,array('id'=>'name','class'=>'form-control')) }}
						</div>
						<div class="mb-3">
							{{ Form::label('description','Content',array('id'=>'','class'=>'')) }}
							{{ Form::textarea('description', $helpCategory->description,array('id'=>'description','class'=>'form-control', 'rows'=>'2')) }}
						</div>
						<div class="row">
							<div class="col-lg-6 col-sm-12 mb-3">
								{{ Form::label('status','Status',array('id'=>'','class'=>'')) }}
								{{
									Form::select(
										'status',
										array(
											'draft'=>'Draft',
											'published'=>'Published',
										),
										strtolower($helpCategory->status),
										array(
											'id'=>'status',
											'class'=>'form-control'
										)
									)
								}}
							</div>
							 <div class="col-lg-6 col-sm-12 mb-3">
								{{ Form::label('event_id','Event',array('id'=>'','class'=>'')) }}
								{{
									Form::select(
										'event_id',
										Helpers::getEventNames('DESC', 0),
										strtolower($helpCategory->event_id),
										array(
											'id'=>'event_id',
											'class'=>'form-control'
										)
									)
								}}
							</div>
						</div>
						<button type="submit" class="btn btn-success btn-block">Submit</button>
					{{ Form::close() }}
					<hr>
					{{ Form::open(array('url'=>'/admin/help/' . $helpCategory->slug, 'onsubmit' => 'return ConfirmDelete()')) }}
						{{ Form::hidden('_method', 'DELETE') }}
						<button type="submit" class="btn btn-danger btn-block">Delete</button>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Attachments Modal -->
@foreach ($entrys as $entry)
	<div class="modal fade" id="attachmentManagerModal{{$entry->id}}" tabindex="-1" role="dialog" aria-labelledby="attachmentManagerModalLabel{{$entry->id}}" aria-hidden="true">		
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="attachmentManagerModalLabel{{$entry->id}}">@lang('help.attachmentmanager')</h4>
					<button type="button" class="btn-close text-decoration-none" data-bs-dismiss="modal" aria-hidden="true"></button>
				</div>
				<div class="modal-body">
					<div class="mb-3">
						<table width="100%" class="table" id="dataTables-example">
							<thead>
								<tr>
									<th>@lang('help.uploadedattachments')</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($entry->attachments as $attachment)
									<tr>
										<td>
											<div>{{ $attachment->display_name }}</div>
										</td>
										<td>
											{{ Form::open(array('url'=>'/admin/help/' . $helpCategory->slug . '/' . $entry->id . '/' . $attachment->id, 'files' => true, 'onsubmit' => 'return ConfirmDelete()')) }}
												{{ Form::hidden('_method', 'DELETE') }}
												<button type="submit" class="btn btn-danger btn-block">Delete</button>
											{{ Form::close() }}
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						{{ Form::open(array('url'=>'/admin/help/' . $helpCategory->slug . '/' . $entry->id . '/upload', 'files' => 'true')) }}
							<div class="mb-3">
								{{ Form::label('attachments','Upload new attachments',array('id'=>'','class'=>'')) }}
								{{ Form::file('attachments[]',array('id'=>'attachments','class'=>'form-control', 'multiple'=>true)) }}
							</div>
							<button type="submit" class="btn btn-primary btn-block">Upload</button>
						{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endforeach
<script type="text/javascript">
	jQuery( function() {
		jQuery( "#start_date" ).datepicker();
		jQuery( "#end_date" ).datepicker();
	});
</script>

@endsection