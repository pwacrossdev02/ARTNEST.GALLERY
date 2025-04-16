@extends('seller.layouts.app')

@section('panel_content')

<div class="aiz-titlebar mt-2 mb-4">
	<div class="row align-items-center">
		<div class="col-md-8">
			<h1 class="h3">{{ translate('All Artists') }}</h1>
		</div>
		<div class="col-md-4">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBrandModal">
				Add New Artists
			</button>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header row gutters-5">
				<div class="col text-center text-md-left">
					<h5 class="mb-md-0 h6">{{ translate('Artists') }}</h5>
				</div>
				<div class="col-md-4">
					<form class="" id="sort_brands" action="" method="GET">
						<div class="input-group input-group-sm">
							<input type="text" class="form-control" id="search" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
						</div>
					</form>
				</div>
			</div>
			<div class="card-body">
				<table class="table aiz-table mb-0">
					<thead>
						<tr>
							<th>#</th>
							<th>{{translate('Name')}}</th>
							<th>{{translate('Logo')}}</th>
							<th class="text-right">{{translate('Options')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($brands as $key => $brand)
						<tr>
							<td>{{ ($key+1) + ($brands->currentPage() - 1)*$brands->perPage() }}</td>
							<td>{{ $brand->getTranslation('name') }}</td>
							<td>
								<img src="{{ uploaded_asset($brand->logo) }}" alt="{{translate('Brand')}}" class="h-50px">
							</td>
							<td class="text-right">
								<a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('sellerbrands.edit', ['id'=>$brand->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
									<i class="las la-edit"></i>
								</a>
								<!-- <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('sellerbrands.destroy', $brand->id)}}" title="{{ translate('Delete') }}">
									<i class="las la-trash"></i>
								</a> -->
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<div class="aiz-pagination">
					{{ $brands->appends(request()->input())->links() }}
				</div>
			</div>
		</div>
	</div>


	<!-- Bootstrap Modal -->
	<div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addBrandModalLabel">{{ translate('Add New Artists') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<!-- Form Content -->
					<div class="card">
						<div class="card-body">
							<form action="{{ route('sellerbrands.store') }}" method="POST">
								@csrf
								<div class="form-group mb-3">
									<label for="name">{{translate('Name')}}</label>
									<input type="text" placeholder="{{translate('Name')}}" name="name" class="form-control" required>
								</div>
								<div class="form-group mb-3">
									<label for="logo">{{translate('Logo')}} <small>({{ translate('120x80') }})</small></label>
									<div class="input-group" data-toggle="aizuploader" data-type="image">
										<div class="input-group-prepend">
											<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
										</div>
										<div class="form-control file-amount">{{ translate('Choose File') }}</div>
										<input type="hidden" name="logo" class="selected-files">
									</div>
									<div class="file-preview box sm"></div>
									<small class="text-muted">{{ translate('Minimum dimensions required: 126px width X 100px height.') }}</small>
								</div>
								<div class="form-group mb-3 text-right">
									<button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

@endsection

@section('modal')
@include('modals.delete_modal')
@endsection

@section('script')
<script type="text/javascript">
	function sort_brands(el) {
		$('#sort_brands').submit();
	}
</script>
@endsection