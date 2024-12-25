 <!-- row -->
 <div class="container-fluid">
     <div class="row page-titles mx-0">
         <div class="col-sm-6 p-md-0">
             <div class="welcome-text">
                 <h4>All Right</h4>
             </div>
         </div>
         <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
             <ol class="breadcrumb">
                 <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                 <li class="breadcrumb-item active"><a href="javascript:void(0);">All My Right</a></li>
             </ol>
         </div>
     </div>
     <div class="row">
         <div class="col-lg-12">
             <div class="row tab-content">
                 <div id="list-view" class="tab-pane fade active show col-lg-12">
                     <div class="card">
                         <div class="card-header">
                             <h4 class="card-title">All Right</h4>
                             <a href="#" class="btn btn-primary" id="add-my_right">+ Add new</a>
                         </div>
                         <div class="card-body">
                             <div class="table-responsive">
                                 <table id="example3" class="display" style="min-width: 845px">
                                     <thead>
                                         <tr>
                                             <th>#</th>
                                             <th>Title</th>
                                             <th>Definition</th>
                                             <th>Simplefied</th>
                                             <th>Action</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         @if($my_rights->count() > 0)
                                         @foreach ($my_rights as $key=>$item)
                                         <tr>
                                             <td>{{ ++$key }}</td>
                                             <td>{{$item->title}}</td>
                                             <td>{{$item->text_definition}}</td>
                                             <td>{{$item->simplefied}}</td>
                                             <td>
                                                 <a href="javascript:void(0);" data-id="{{ $item->id }}" id="my_right-edit" class="btn btn-sm btn-primary"><i class="la la-pencil"></i></a>
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