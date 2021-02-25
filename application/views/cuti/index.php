<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- <form action="<?= base_url('cuti/store') ?>" method="post"> -->
                <form method="post" id="formcuti">
                <div class="card-header">
                    <h4 class="card-title">Form Cuti</h4>
                </div>
                <div class="card-body border-top py-0 my-3">
                    <h4 class="text-muted my-3">Karyawan</h4>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            
                            <div class="form-group">
                                <label for="divisi">Divisi : </label>
                                <select name="divisi" id="divisi" class="form-control">
                                    <option value="" disabled selected>-- Pilih Divisi --</option>
                                    <?php foreach($divisi as $d): ?>
                                        <option value="<?= $d->id_divisi ?>"><?= $d->nama_divisi ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span id="divisi_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="divisi">Karyawan : </label>
                                <select name="karyawan" id="karyawan" class="form-control">
                                    <option value="" disabled selected>-- Pilih Karyawan --</option>
                                  <!--   <?php foreach($karyawan as $d): ?>
                                        <option value="<?= $d->id_user ?>"><?= $d->nama ?></option>
                                    <?php endforeach; ?> -->
                                </select>
                                <span id="karyawan_error" class="text-danger"></span>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="card-body border-top py-0 my-3">
                    <h4 class="text-muted my-3">Cuti</h4>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="divisi">Jenis Cuti : </label>
                                <select name="jenis_cuti" id="divisi" class="form-control">
                                    <option value="" disabled selected>-- Pilih Jenis Cuti --</option>
                                    <option value="1">Cuti</option>
                                    <option value="2">Sakit</option>
                                    <option value="3">Izin</option>
                                </select>
                                <span id="jenis_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="divisi">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" required="reuqired" />
                                <span id="jenis_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="password">Keterangan</label>
                               <textarea class="form-control" name="keterangan" id="exampleFormControlTextarea1" rows="3"></textarea>
                               <span id="keterangan_error" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan <i class="fa fa-save"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript">
        $(document).ready(function(){
 
            $('#divisi').change(function(){ 
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('cuti/getKaryawan');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                         
                        var html = '';
                        var i;
                        if(!Object.keys(data).length){
                            html += '<option value=0>Tidak ada Data</option>';
                        }
                        else {
                            for(i=0; i<data.length; i++){
                                html += '<option value='+data[i].id_users+'>'+data[i].nama+'</option>';
                            }
                        }
                        
                        $('#karyawan').html(html);
 
                    }
                });
                return false;
            }); 

            $(document).on('submit', '#formcuti', function(e) {
                e.preventDefault();
                $('.text-danger').html('');

                $.ajax({
                    url         : "<?php echo site_url('cuti/store');?>",
                    type        : 'POST',
                    data        : $(this).serialize(),
                    cache       : false,
                    dataType    : 'json',
                    success     : function(data) {
                        if(data.error == false) {
                            if(data.nik != '') {
                                $('#divisi_error').html(data.divisi);
                            } else {
                                $('#nik_error').html('');
                            }
                            if(data.karyawan != '') {
                                $('#karyawan_error').html(data.karyawan);
                            } else {
                                $('#karyawan_error').html('');
                            }
                             if(data.jenis_cuti != '') {
                                $('#jenis_error').html(data.jenis_cuti);
                            } else {
                                $('#jenis_error').html('');
                            }
                             if(data.keterangan != '') {
                                $('#keterangan_error').html(data.keterangan);
                            } else {
                                $('#keterangan_error').html('');
                            }
                        } else {
                            
                            window.location =  "<?php echo site_url('cuti');?>";
                        }
                    }
                });
            });
             
        });
    </script>