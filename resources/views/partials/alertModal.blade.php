<!-- Logout Modal-->
   <div class="modal fade" id="alertModal-{{ $dataDetails->id }}" tabindex="-1">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">Are You Sure to Proceed?</h5>
                   <button class="close" type="button" data-bs-dismiss="modal">
                       <span aria-hidden="true">×</span>
                   </button>
               </div>
               <div class="modal-body">Select "Delete" below if you are ready to delete your current record.</div>
               <div class="modal-footer">
                   <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                   <form method="POST" action="{{ route("{$table}.destroy", $dataDetails->id) }}"  style="display:inline">
                       
                   @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" href="{{ route("{$table}.destroy", $dataDetails->id) }}">Delete
                        </button>
                    </form>
               </div>
           </div>
       </div>
   </div>