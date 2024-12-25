 <!-- row -->
 <div class="container-fluid">

     <div class="row page-titles mx-0">
         <div class="col-sm-6 p-md-0">
             <div class="welcome-text">
                 <h4>Create Quote</h4>
             </div>
         </div>
         <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
             <ol class="breadcrumb">
                 <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                 <li class="breadcrumb-item active"><a href="javascript:void(0);">Create Quote</a></li>
             </ol>
         </div>
     </div>

     <div class="row">
         <div class="col-lg-12">
             <ul class="nav nav-pills mb-3">
                 <li class="nav-item"><a href="#" data-toggle="tab" class="nav-link btn-primary mr-1 show active" id="quote-list">List View</a></li>
             </ul>
         </div>
         <div class="col-xl-12 col-xxl-12 col-sm-12">
             <div class="card">
                 <div class="card-header">
                     <h5 class="card-title">Quote Info</h5>
                 </div>
                 <div class="card-body">
                     <form id="quote-form">
                         <div class="row">
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Title</label>
                                     <input type="text" class="form-control" name="title" placeholder="Enter a title..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Image</label>
                                     <input type="file" class="form-control" name="image">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Date</label>
                                     <input type="date" class="form-control" name="date" min="<?= date('Y-m-d') ?>">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Description</label>
                                     <textarea class="form-control" name="description" rows="3"></textarea>
                                 </div>
                             </div>
                         </div>
                         <div class="col-lg-12 col-md-12 col-sm-12">
                             <button type="button" id="btn-add-quote" class="btn btn-primary">Submit</button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>