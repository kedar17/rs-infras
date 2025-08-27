   <!-- Scroll to Top Button-->
   <a class="scroll-to-top rounded" href="#page-top">
       <i class="fas fa-angle-up"></i>
   </a>

   <!-- Logout Modal-->
   <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
       aria-hidden="true">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                   <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">×</span>
                   </button>
               </div>
               <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
               <div class="modal-footer">
                   <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                   <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-primary" href="{{ route('logout') }}">Logout
                        </button>
                    </form>
               </div>
           </div>
       </div>
   </div>

   <!-- Bootstrap core JavaScript-->
   <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   <!-- Core plugin JavaScript-->
   <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

   <!-- Custom scripts for all pages-->
   <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
   <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>