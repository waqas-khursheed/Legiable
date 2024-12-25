 <!-- row -->
 <div class="container-fluid">

     <div class="row page-titles mx-0">
         <div class="col-sm-6 p-md-0">
             <div class="welcome-text">
                 <h4>Update Executive</h4>
             </div>
         </div>
         <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
             <ol class="breadcrumb">
                 <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                 <li class="breadcrumb-item active"><a href="javascript:void(0);">Update Executive</a></li>
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
                     <form id="executive-update-form">
                         <div class="row">
                             <input type="hidden" name="id" value="{{ $executive->id }}">

                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">First Name</label>
                                     <input type="text" class="form-control" value="{{ $executive->first_name }}" name="first_name" placeholder="Enter a First Name..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Last Name</label>
                                     <input type="text" class="form-control" value="{{ $executive->last_name }}" name="last_name" placeholder="Enter a Last Name..">
                                 </div>
                             </div>

                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Party</label>
                                     <select class="form-control" name="party">
                                         <option value="">Select Party</option>
                                         <option value="Republican" {{ $executive->party == 'Republican' ? 'selected' : '' }}>Republican</option>
                                         <option value="Democratic" {{ $executive->party == 'Democratic' ? 'selected' : '' }}>Democratic</option>
                                     </select>
                                 </div>
                             </div>

                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Jurisdiction</label>
                                     <input type="text" class="form-control" value="{{ $executive->jurisdiction }}" name="jurisdiction" placeholder="Enter a Jurisdiction..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">State</label>
                                     <input type="text" class="form-control" value="{{ $executive->state }}" name="state" placeholder="Enter a State..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">City</label>
                                     <input type="text" class="form-control" value="{{ $executive->city }}" name="city" placeholder="Enter a City..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Home City</label>
                                     <input type="text" class="form-control" value="{{ $executive->home_city }}" name="home_city" placeholder="Enter a Home City..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Committees</label>
                                     <input type="text" class="form-control" value="{{ $executive->committees }}" name="committees" placeholder="Enter a Committees..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Birthday</label>
                                     <input type="date" class="form-control" value="{{ $executive->birthday }}" max="{{ date('Y-m-d') }}" name="birthday" placeholder="Enter a Birthday..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Birth Place</label>
                                     <input type="text" class="form-control" value="{{ $executive->birth_place }}" name="birth_place" placeholder="Enter a Birth Place..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Religion</label>
                                     <input type="text" class="form-control" value="{{ $executive->religion }}" name="religion" placeholder="Enter a Religion..">
                                 </div>
                             </div>

                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">On The Ballot</label>
                                     <select class="form-control" name="on_the_ballot">
                                         <option value="">Select On The Ballot</option>
                                         <option value="1"{{ $executive->on_the_ballot == '1' ? 'selected' : '' }}>True</option>
                                         <option value="0"{{ $executive->on_the_ballot == '0' ? 'selected' : '' }}>False</option>
                                     </select>
                                 </div>
                             </div>

                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Education</label>
                                     <textarea class="form-control" name="education" rows="4">{{ $executive->education }}</textarea>
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Contact Campaign Other</label>
                                     <textarea class="form-control" name="contact_campaign_other" rows="4">{{ $executive->contact_campaign_other }}</textarea>
                                 </div>
                             </div>

                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Campaign Website</label>
                                     <input type="text" class="form-control" value="{{ $executive->campaign_website }}" name="campaign_website" placeholder="Enter a Campaign Website..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">DC Contact</label>
                                     <input type="text" class="form-control" value="{{ $executive->dc_contact }}" name="dc_contact" placeholder="Enter a DC Contact..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">DC Website</label>
                                     <input type="text" class="form-control" value="{{ $executive->dc_website }}" name="dc_website" placeholder="Enter a DC Website..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Instagram</label>
                                     <input type="text" class="form-control" value="{{ $executive->instagram }}" name="instagram" placeholder="Enter a Instagram..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Facebook</label>
                                     <input type="text" class="form-control" value="{{ $executive->facebook }}" name="facebook" placeholder="Enter a Facebook..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Twitter</label>
                                     <input type="text" class="form-control" value="{{ $executive->twitter }}" name="twitter" placeholder="Enter a Twitter..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Linkedin</label>
                                     <input type="text" class="form-control" value="{{ $executive->linkedin }}" name="linkedin" placeholder="Enter a Linkedin..">
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Youtube</label>
                                     <input type="text" class="form-control" value="{{ $executive->youtube }}" name="youtube" placeholder="Enter a Youtube..">
                                 </div>
                             </div>

                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Political Experience</label>
                                     <textarea class="form-control" name="political_experience" rows="4">{{ $executive->political_experience }}</textarea>
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Professional Experience</label>
                                     <textarea class="form-control" name="professional_experience" rows="4">{{ $executive->professional_experience }}</textarea>
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Military Experience</label>
                                     <textarea class="form-control" name="military_experience" rows="4">{{ $executive->military_experience }}</textarea>
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Other Experience</label>
                                     <textarea class="form-control" name="other_experience" rows="4">{{ $executive->other_experience }}</textarea>
                                 </div>
                             </div>
                             <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="form-group">
                                     <label class="form-label">Other Facts</label>
                                     <textarea class="form-control" name="other_facts" rows="4">{{ $executive->other_facts }}</textarea>
                                 </div>
                             </div>
                         </div>
                         <div class="col-lg-12 col-md-12 col-sm-12">
                             <button type="button" id="btn-update-executive" class="btn btn-primary">Submit</button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>