<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>উত্তরাধিকার সনদ তৈরি করুন</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin-top: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .form-label {
            font-weight: bold;
        }
        .table th {
            background-color: #5fa2db;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h3>উত্তরাধিকার সনদ তৈরি করুন</h3>
            </div>
            <div class="card-body">
                <form action="certificate.php" method="POST" autocomplete="on">
                    <div class="mb-3">
                        <label for="certificate_year" class="form-label">সনদ সাল</label>
                        <input type="number" 
                               class="form-control" 
                               id="certificate_year" 
                               name="certificate_year" 
                               value="<?php echo date('Y'); ?>"
                               min="2000"
                               max="<?php echo date('Y') + 1; ?>"
                               required>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label>ইউনিয়নের নাম</label>
                            <input class="form-control" type="text" name="union_name" value="৭ নংনারায়ণপুর ইউনিয়ন পরিষদ" placeholder="ইউনিয়নের নাম" required>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label>ইউনিয়নের ঠিকানা</label>
                            <input class="form-control" type="text" name="union_address" value="ডাকঃ নারায়ণপুর, উপজেলাঃ নবাবগঞ্জ, জেলাঃ ঢাকা" placeholder="ইউনিয়নের ঠিকানা" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <label>ওয়ার্ড নং</label>
                            <input class="form-control" type="number" name="ward_no" value="" placeholder="ওয়ার্ড নং" required>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>গ্রামের নাম</label>
                            <input class="form-control" type="text" name="village_name" value="" placeholder="গ্রামের নাম" required>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>ডাকঘর</label>
                            <input class="form-control" type="text" name="post_office" value="" placeholder="ডাকঘর" required>
                        </div>
                        <div class="form-group col-sm-2">
                            <label>থানা</label>
                            <input class="form-control" type="text" name="thana" value="" placeholder="থানা" required>
                        </div>
                        <div class="form-group col-sm-2">
                            <label>উপজেলা</label>
                            <input class="form-control" type="text" name="upozila" value="" placeholder="উপজেলা" required>
                        </div>
                        <div class="form-group col-sm-2">
                            <label>জেলা</label>
                            <input class="form-control" type="text" name="zila" value="" placeholder="জেলা" required>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class="form-group">
                                <div class="input-group-icon input-group-icon-left">
                                    <span class="input-icon input-icon-left">
                                        <span class="material-icons">how_to_reg</span>
                                    </span>
                                    <select class="form-control" name="gender" id="gender" style="width: 100%">
                                        <option value="">লিঙ্গ</option>
                                        <option value="male">পুরুষ</option>
                                        <option value="female">নারী</option>
                                        <option value="other">অন্যান্য</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class="form-group">
                                <div class="input-group-icon input-group-icon-left">
                                    <span class="input-icon input-icon-left">
                                        <span class="material-icons">how_to_reg</span>
                                    </span>
                                    <select class="form-control" name="he_she_is" id="he_she_is" style="width: 100%">
                                        <option value="">সনদের ধরন</option>
                                        <option value="death">মৃত ব্যক্তির জন্য</option>
                                        <option value="live">জীবিত ব্যক্তির জন্য</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>মৃত্যু সনদ নং</label>
                            <input class="form-control" type="text" name="death_certificates_id" value="" placeholder="মৃত্যু সনদ নং" maxlength="17">
                        </div>
                        <div class="form-group col-sm-2">
                            <label>মৃত্যু তারিখ</label>
                            <input class="form-control" type="date" name="dod" value="" placeholder="মৃত্যু তারিখ">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label>নাম (বাংলা)</label>
                            <input class="form-control" type="text" name="person_bn" value="" placeholder="" maxlength="150" required>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label>পিতা/স্বামী (বাংলা)</label>
                            <input class="form-control" type="text" name="guardian_bn" value="" placeholder="" maxlength="150" required>
                        </div>
                    </div>
                    <div class="table">
                        <table class="table table-borderless" id="newRows">
                            <thead class="text-white text-center" style="background-color: #5fa2db">
                                <tr class="form-row">
                                    <th class="col" colspan="3">
                                        <h3 style="color: red;">স্বজনদের নাম</h3>
                                        <hr>
                                    </th>
                                </tr>
                                <tr class="form-row">
                                    <th class="form-group col-md-8" style="color: red;">নাম (বাংলা)</th>
                                    <th class="form-group col-md-4" style="color: red;">সম্পর্ক</th>                             
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="form-row">
                                    <td class="form-group col-md-8">
                                        <input type="text" id="name_bn" class="form-control" name="name_bn[]" value="" placeholder="নাম" required/>
                                    </td>
                                    <td class="form-group col-md-4">
                                        <select name="Relatives[]" id="Relatives" class="form-control">
                                            <option value="পিতা">পিতা</option>
                                            <option value="মাতা">মাতা</option>
                                            <option value="স্বামী">স্বামী</option>
                                            <option value="স্ত্রী">স্ত্রী</option>
                                            <option value="ভাই">ভাই</option>
                                            <option value="সৎ ভাই">সৎ ভাই</option>
                                            <option value="বোন">বোন</option>
                                            <option value="পুত্র">পুত্র</option>
                                            <option value="কন্যা">কন্যা</option>
                                            <option value="নাতি">নাতি</option>
                                            <option value="ভাতিজা">ভাতিজা</option>
                                            <option value="ভাতিজী">ভাতিজী</option>
                                            <option value="দাদী">দাদী</option>
                                        </select>
                                    </td>
                                    <td></td> <!-- Added empty cell for alignment -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <button type="button" id="addRowBtn" class="btn btn-danger w-100">যুক্ত করুন</button>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-primary btn-block">আবেদন দাখিল</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addRowBtn').addEventListener('click', function() {
                var tbody = document.querySelector('#newRows tbody');
                var tr = document.createElement('tr');
                tr.className = 'form-row';
                
                tr.innerHTML = `
                    <td class="form-group col-md-8">
                        <input type="text" class="form-control" name="name_bn[]" placeholder="নাম" required/>
                    </td>
                    <td class="form-group col-md-4">
                        <select name="Relatives[]" class="form-control">
                            <option value="পিতা">পিতা</option>
                            <option value="মাতা">মাতা</option>
                            <option value="স্বামী">স্বামী</option>
                            <option value="স্ত্রী">স্ত্রী</option>
                            <option value="ভাই">ভাই</option>
                            <option value="সৎ ভাই">সৎ ভাই</option>
                            <option value="বোন">বোন</option>
                            <option value="পুত্র">পুত্র</option>
                            <option value="কন্যা">কন্যা</option>
                            <option value="নাতি">নাতি</option>
                            <option value="ভাতিজা">ভাতিজা</option>
                            <option value="ভাতিজী">ভাতিজী</option>
                            <option value="দাদী">দাদী</option>
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger removeRow">✕</button>
                    </td>
                `;
                
                tbody.appendChild(tr);
                
                var removeButtons = document.querySelectorAll('.removeRow');
                removeButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        this.closest('tr').remove();
                    });
                });
            });
            
            var removeButtons = document.querySelectorAll('.removeRow');
            removeButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    this.closest('tr').remove();
                });
            });
        });
    </script>
</body>
</html>
