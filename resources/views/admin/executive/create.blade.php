 <!-- row -->
 <div class="container-fluid">

     <div class="row page-titles mx-0">
         <div class="col-sm-6 p-md-0">
             <div class="welcome-text">
                 <h4>Create Executive</h4>
             </div>
         </div>
         <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
             <ol class="breadcrumb">
                 <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                 <li class="breadcrumb-item active"><a href="javascript:void(0);">Create Executive</a></li>
             </ol>
         </div>
     </div>

     <div class="row">
         <div class="col-lg-12">
             <ul class="nav nav-pills mb-3">
                 <li class="nav-item"><a href="#" data-toggle="tab" class="nav-link btn-primary mr-1 show active" id="executive-list">List View</a></li>
             </ul>
         </div>
         <div class="col-xl-12 col-xxl-12 col-sm-12">
             <div class="card">
                 <div class="card-header">
                     <h5 class="card-title">Executive Info</h5>
                 </div>
                 <div class="card-body">
                     <form id="executive-form">
                         <div class="row">
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">First Name</label>
                                     <input type="text" class="form-control" name="first_name" placeholder="Enter a First Name..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Last Name</label>
                                     <input type="text" class="form-control" name="last_name" placeholder="Enter a Last Name..">
                                 </div>
                             </div>

                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Party</label>
                                     <select class="form-control" name="party">
                                         <option value="">Select Party</option>
                                         <option value="Republican">Republican</option>
                                         <option value="Democratic">Democratic</option>
                                     </select>
                                 </div>
                             </div>

                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Jurisdiction</label>
                                     <input type="text" class="form-control" name="jurisdiction" placeholder="Enter a Jurisdiction..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">State</label>
                                     <input type="text" class="form-control" name="state" placeholder="Enter a State..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">City</label>
                                     <input type="text" class="form-control" name="city" placeholder="Enter a City..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Home City</label>
                                     <input type="text" class="form-control" name="home_city" placeholder="Enter a Home City..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Committees</label>
                                     <input type="text" class="form-control" name="committees" placeholder="Enter a Committees..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Birthday</label>
                                     <input type="date" class="form-control" name="birthday" max="{{ date('Y-m-d') }}" placeholder="Enter a Birthday..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Birth Place</label>
                                     <input type="text" class="form-control" name="birth_place" placeholder="Enter a Birth Place..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Religion</label>
                                     <input type="text" class="form-control" name="religion" placeholder="Enter a Religion..">
                                 </div>
                             </div>

                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">On The Ballot</label>
                                     <select class="form-control" name="on_the_ballot">
                                         <option value="">Select On The Ballot</option>
                                         <option value="1">True</option>
                                         <option value="0">False</option>
                                     </select>
                                 </div>
                             </div>

                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Education</label>
                                     <textarea class="form-control" name="education" rows="4"></textarea>
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Contact Campaign Other</label>
                                     <textarea class="form-control" name="contact_campaign_other" rows="4"></textarea>
                                 </div>
                             </div>

                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Campaign Website</label>
                                     <input type="text" class="form-control" name="campaign_website" placeholder="Enter a Campaign Website..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">DC Contact</label>
                                     <input type="text" class="form-control" name="dc_contact" placeholder="Enter a DC Contact..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">DC Website</label>
                                     <input type="text" class="form-control" name="dc_website" placeholder="Enter a DC Website..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Instagram</label>
                                     <input type="text" class="form-control" name="instagram" placeholder="Enter a Instagram..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Facebook</label>
                                     <input type="text" class="form-control" name="facebook" placeholder="Enter a Facebook..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Twitter</label>
                                     <input type="text" class="form-control" name="twitter" placeholder="Enter a Twitter..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Linkedin</label>
                                     <input type="text" class="form-control" name="linkedin" placeholder="Enter a Linkedin..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Youtube</label>
                                     <input type="text" class="form-control" name="youtube" placeholder="Enter a Youtube..">
                                 </div>
                             </div>

                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Political Experience</label>
                                     <textarea class="form-control" name="political_experience" rows="4"></textarea>
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Professional Experience</label>
                                     <textarea class="form-control" name="professional_experience" rows="4"></textarea>
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Military Experience</label>
                                     <textarea class="form-control" name="military_experience" rows="4"></textarea>
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Other Experience</label>
                                     <textarea class="form-control" name="other_experience" rows="4"></textarea>
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Other Facts</label>
                                     <textarea class="form-control" name="other_facts" rows="4"></textarea>
                                 </div>
                             </div>
                         </div>
                         <div class="col-lg-12 col-md-12 col-sm-12">
                             <button type="button" id="btn-add-executive" class="btn btn-primary">Submit</button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>