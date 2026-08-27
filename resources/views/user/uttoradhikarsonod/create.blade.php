@extends('user.layouts.app')

@section('content')
<div>
    <div class="card card-fullheight">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('user.uttoradhikarsonod.store') }}" method="POST" autocomplete="on">
                    @csrf

                @php
                    $serviceCharge = \App\Models\ServiceCharge::where('service_name', 'uttoradhikarsonod')->first();
                @endphp

                @if($serviceCharge)
                    <div class="alert alert-info alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle fa-2x mr-3 text-info"></i>
                            <div>
                                <h6 class="alert-heading mb-1 font-weight-bold">সার্ভিস চার্জ</h6>
                                <p class="mb-0 small text-muted">প্রতিটি উত্তরাধিকার সনদ তৈরির জন্য <span class="font-weight-bold text-danger">{{ number_format($serviceCharge->amount, 2) }}</span> টাকা কাটা হবে।</p>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                    <div class="mb-3">
                        <label for="certificate_number" class="form-label">সনদ সাল</label>
                        <input type="number" 
                               class="form-control @error('certificate_number') is-invalid @enderror" 
                               id="certificate_number" 
                               name="certificate_number" 
                               value="{{ old('certificate_number', $currentYear) }}"
                               min="2000"
                               max="{{ date('Y') + 1 }}"
                               required>
                        @error('certificate_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label>ইনিয়নের না</label>
                            <input class="form-control" type="text" name="union_name" value="{{ $union_name }}" placeholder="ইউনিয়নের নাম" required>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label>ইউনিয়নের ঠিানা</label>
                            <input class="form-control" type="text" name="union_address" value="{{ $union_address }}" placeholder="ইউিয়নের ঠিকানা" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <label>ওয়ার্ড নং</label>
                            <input class="form-control" type="number" name="word_no" value="" placeholder="ওয়ার্ড ন" required>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>গ্রামে নাম</label>
                            <input class="form-control" type="text" name="village_name" value="" placeholder="গ্রামের না" required>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>ডাকঘর</label>
                            <input class="form-control" type="text" name="post_office" value="" placeholder="ডাকঘ" required>
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
                            <input class="form-control" type="text" name="zila" value="" placeholder="েলা" required>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class="form-group">
                                <div class="input-group-icon input-group-icon-left">
                                    <span class="input-icon input-icon-left">
                                        <span class="material-icons">how_to_reg</span>
                                    </span>
                                    <select class="form-control select2" name="gender" id="gender" style="width: 100%">
                                        <option value="">লিঙ্গ</option>
                                        <option value="male">পরুষ</option>
                                        <option value="female">নার</option>
                                        <option value="other">অন্যান্</option>
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
                                    <select class="form-control select2" name="he_she_is" id="he_she_is" style="width: 100%">
                                        <option value="">সদের ধরন</option>
                                        <option value="death">মৃত ব্যক্তির জন্য</option>
                                        <option value="live">জীবিত ব্যক্তির জন্য</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <input class="form-control" type="text" name="death_certificates_id" value="" placeholder="মৃত্যু সনদ ং" maxlength="17">
                        </div>
                        <div class="form-group col-sm-2">
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
                                        <h3 style="color: red;">স্বজনদে নাম</h3>
                                        <hr>
                                    </th>
                                </tr>
                                <tr class="form-row">
                                    <th class="form-group col-md-8" style="color: red;">নাম (বাংলা)</th>
                                    <th class="form-group col-md-4" style="color: red;">স্পর্ক</th>                             
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="form-row">
                                    <td class="form-group col-md-8">
                                        <input type="text" id="name_bn" class="form-control" name="name_bn[]" value="" placeholder="নাম" required/>
                                    </td>
                                    <td class="form-group col-md-4">
                                        <select name="Relatives[]" id="Relatives" class="form-control select2">
                                            <option value="পতা">পিতা</option>
                                            <option value="মতা">মাতা</option>
                                            <option value="সবামী">স্বাম</option>
                                            <option value="স্ত্রী">সত্রী</option>
                                            <option value="ভাই">াই</option>
                                            <option value="সৎ ভাই">ৎ ভাই</option>
                                            <option value="বোন">বোন</option>
                                            <option value="পুত্র">পুত্র</option>
                                            <option value="কন্া">কন্যা</option>
                                            <option value="নতি">নাতি</option>
                                            <option value="ভতিজা">ভাতিজ</option>
                                            <option value="ভাতিজী">ভতিজী</option>
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
                        <button class="btn btn-outline-primary btn-block">আবেদন দাখিল </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add row functionality
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
                        <option value="পতা">পিতা</option>
                        <option value="মাতা">মাত</option>
                        <option value="স্বামী">স্বামী</option>
                        <option value="স্ত্রী">স্ত্রী</option>
                        <option value="ভাই">ভাই</option>
                        <option value="সৎ ভাই">স ভাই</option>
                        <option value="োন">বোন</option>
                        <option value="পুত্র">পুতর</option>
                        <option value="কন্া">কন্যা</option>
                        <option value="নাতি">নাত</option>
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
            
            // Initialize Select2 if it's being used
            if (typeof $.fn.select2 !== 'undefined') {
                $(tr).find('select').select2();
            }
            
            // Add event listeners to remove buttons
            var removeButtons = document.querySelectorAll('.removeRow');
            removeButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    this.closest('tr').remove();
                });
            });
        });
        
        // Initialize event listeners for existing remove buttons
        var removeButtons = document.querySelectorAll('.removeRow');
        removeButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                this.closest('tr').remove();
            });
        });
    });
</script>
@endsection