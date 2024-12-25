 <!-- row -->
 <div class="container-fluid">
     <div class="row page-titles mx-0">
         <div class="col-sm-6 p-md-0">
             <div class="welcome-text">
                 <h4>All Quote</h4>
             </div>
         </div>
         <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
             <ol class="breadcrumb">
                 <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                 <li class="breadcrumb-item active"><a href="javascript:void(0);">All Quote</a></li>
             </ol>
         </div>
     </div>
     <div class="row">
         <div class="col-lg-12">
             <div class="row tab-content">
                 <div id="list-view" class="tab-pane fade active show col-lg-12">
                     <div class="card">
                         <div class="card-header">
                             <h4 class="card-title">All Quote</h4>
                             <a href="#" class="btn btn-primary" id="add-quote">+ Add new</a>
                         </div>
                         <div class="card-body">
                             <div class="table-responsive">
                                 <table id="example3" class="display" style="min-width: 845px">
                                     <thead>
                                         <tr>
                                             <th>#</th>
                                             <th>Title</th>
                                             <th>Date</th>
                                             <th>Description</th>
                                             <th>Image</th>
                                             <th>Default</th>
                                             <th>Action</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         @if($quotes->count() > 0)
                                         @foreach ($quotes as $key=>$item)
                                         <tr>
                                             <td>{{ ++$key }}</td>
                                             <td>{{$item->title}}</td>
                                             <td>{{$item->date}}</td>
                                             <td>{{$item->description}}</td>
                                             <td>
                                                 <a href="{{ asset($item->image) }}" target="_blank">
                                                     <img src="{{ asset($item->image) }}" style="width:90px">
                                                 </a>
                                             </td>
                                             <td>
                                                 <div class="form-check form-switch">
                                                     <input class="form-check-input" type="checkbox" data-id="{{ $item->id }}" onclick="defaultData({{ $item->id }})" id="flexSwitchCheckDefault{{ $item->id }}" {{ $item->status == 1 ? 'checked' : '' }}>
                                                     <label class="form-check-label" for="flexSwitchCheckDefault{{ $item->id }}"></label>
                                                 </div>
                                             </td>
                                             <td>
                                                 <a href="javascript:void(0);" data-id="{{ $item->id }}" id="quote-edit" class="btn btn-sm btn-primary"><i class="la la-pencil"></i></a>
                                                 <a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="deleteData({{ $item->id }})"><i class="la la-trash-o"></i></a>
                                             </td>
                                         </tr>
                                         @endforeach
                                         @else
                                         <tr>
                                             <td colspan="8" class="center">No Record Found</td>
                                         </tr>
                                         @endif
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>