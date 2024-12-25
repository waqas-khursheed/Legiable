 <!-- row -->
 <div class="container-fluid">

     <div class="row page-titles mx-0">
         <div class="col-sm-6 p-md-0">
             <div class="welcome-text">
                 <h4>Create Right</h4>
             </div>
         </div>
         <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
             <ol class="breadcrumb">
                 <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                 <li class="breadcrumb-item active"><a href="javascript:void(0);">Create Right</a></li>
             </ol>
         </div>
     </div>

     <div class="row">
         <div class="col-lg-12">
             <ul class="nav nav-pills mb-3">
                 <li class="nav-item"><a href="#" data-toggle="tab" class="nav-link btn-primary mr-1 show active" id="my_right-list">List View</a></li>
             </ul>
         </div>
         <div class="col-xl-12 col-xxl-12 col-sm-12">
             <div class="card">
                 <div class="card-header">
                     <h5 class="card-title">Right Info</h5>
                 </div>
                 <div class="card-body">
                     <form id="my_right-form">
                         <div class="row">
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Title</label>
                                     <input type="text" class="form-control" name="title" placeholder="Enter a title..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Text Definition</label>
                                     <textarea class="form-control" name="text_definition" rows="4"></textarea>
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Simplefied</label>
                                     <textarea class="form-control" name="simplefied" rows="4"></textarea>
                                 </div>
                             </div>
                         </div>
                         <div class="col-lg-12 col-md-12 col-sm-12">
                             <button type="button" id="btn-add-my_right" class="btn btn-primary">Submit</button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>