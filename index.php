<!DOCTYPE html>
<html>

<head>
    <title>Kalendar Kegiatan</title>
    <script src='calendar.js'></script>
    <link rel="stylesheet" href="lib/bootstrap.min.css">
    <link href='lib/fullcalendar.css' rel='stylesheet' />
    <script src="lib/jquery-3.2.1.min.js"></script>
    <script src="lib/bootstrap.bundle.min.js"></script>
    <script src='lib/fullcalendar.js'></script>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <select id="monthSelect" class="form-control" style="width: auto;"></select>
                </div>
                <div id="calendar"></div>
            </div>
            <div class="col-lg-4" style="top: 40px">
                <div class="alert alert-warning" role="alert">
                    <h4>Daftar Kegiatan</h4>
                </div>
                <h5>Kegiatan Bulan Ini</h5>
                <ul class="list-group" id="currentMonthEventList" style="margin-bottom: 16px"></ul>
                <h5>Kegiatan Mendatang</h5>
                <ul class="list-group" id="upcomingEventList"></ul>
            </div>
        </div>
    </div>

    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Buat/Perbarui Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="event_action.php" method="POST" id="eventForm">
                        <input type="hidden" name="eventId" id="eventId">
                        <input type="hidden" name="action" id="action">
                        <div class="form-group">
                            <label for="kegiatan">Nama Kegiatan</label>
                            <input type="text" name="kegiatan" class="form-control" id="kegiatan" rows="2" placeholder="Nama Kegiatan" required>
                        </div>
                        <p>Penanggung Jawab</p>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <select id="divisi_pj" name="divisi_pj" class="form-control">
                                    <option value="" selected disabled hidden>Pilih Divisi</option>
                                    <?php
                                    include 'koneksi.php';
                                    $divisi_pj_query = mysqli_query($conn, "SELECT id, divisi FROM tb_divisi_pj");
                                    while ($divisi_pj = mysqli_fetch_assoc($divisi_pj_query)) {
                                        echo '<option value="' . $divisi_pj['id'] . '">' . $divisi_pj['divisi'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" id="penganggung_jawab" name="penganggung_jawab" class="form-control" placeholder="Nama">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="lokasi_type" id="lokasi_type_sekolah" value="sekolah" checked>
                                    <label class="form-check-label" for="lokasi_type_sekolah">Di Sekolah</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="lokasi_type" id="lokasi_type_luar" value="luar">
                                    <label class="form-check-label" for="lokasi_type_luar">Di Luar</label>
                                </div>
                            </div>
                            <div id="lokasi_sekolah" style="display: block;">
                                <select id="lokasi" name="lokasi" class="form-control">
                                    <option value="" selected disabled hidden>Pilih Lokasi di Sekolah</option>
                                    <?php
                                    include 'koneksi.php';
                                    $lokasi_sekolah_query = mysqli_query($conn, "SELECT id, lokasi FROM tb_lokasi WHERE is_sekolah = 1");
                                    while ($lokasi_sekolah = mysqli_fetch_assoc($lokasi_sekolah_query)) {
                                        echo '<option value="' . $lokasi_sekolah['id'] . '">' . $lokasi_sekolah['lokasi'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div id="lokasi_luar" style="display: none;">
                                <input type="text" class="form-control" name="lokasi" id="lokasi" list="lokasiList" placeholder="Lokasi">
                                <datalist id="lokasiList"></datalist>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="peserta">Peserta</label>
                            <textarea name="peserta" class="form-control" id="peserta" rows="2" placeholder="Peserta"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="mulai">Tanggal Mulai</label>
                            <input type="datetime-local" class="form-control" name="mulai" id="mulai" required>
                        </div>
                        <div class="form-group">
                            <label for="selesai">Tanggal Berakhir</label>
                            <input type="datetime-local" class="form-control" name="selesai" id="selesai" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="button" class="btn btn-danger" id="deleteButton" style="display:none;">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('input[type="radio"][name="lokasi_type"]').change(function() {
                if (this.value == 'sekolah') {
                    $('#lokasi_sekolah').show();
                    $('#lokasi_luar').hide();
                    $('#lokasi_luar input[name="lokasi"]').removeAttr('required');
                } else if (this.value == 'luar') {
                    $('#lokasi_sekolah').hide();
                    $('#lokasi_luar').show();
                    $('#lokasi_luar input[name="lokasi"]').attr('required', 'required');
                }
            });
        });
    </script>
</body>

</html>