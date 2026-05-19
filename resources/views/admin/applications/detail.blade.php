<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-user"></i> Thông tin học sinh - Lớp {{ $grade }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Họ tên:</strong></td>
                                <td>{{ $application->fullname }}</td>
                            </tr>
                            <tr>
                                <td><strong>Ngày sinh:</strong></td>
                                <td>{{ $application->birthdate->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Giới tính:</strong></td>
                                <td>{{ $application->gender }}</td>
                            </tr>
                            <tr>
                                <td><strong>Dân tộc:</strong></td>
                                <td>{{ $application->ethnicity ?? 'Không có thông tin' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Trường hiện tại:</strong></td>
                                <td>{{ $application->current_school }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>CCCD/CMND:</strong></td>
                                <td>{{ $application->citizen_id ?? 'Chưa có' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Địa chỉ:</strong></td>
                                <td>{{ $application->address }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nơi sinh:</strong></td>
                                <td>{{ $application->birthplace ?? 'Chưa có' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Số điện thoại:</strong></td>
                                <td>{{ $application->phone }}</td>
                            </tr>
                            <tr>
                                <td><strong>Trạng thái:</strong></td>
                                <td>
                                    @switch($application->status)
                                        @case('pending')
                                            <span class="badge badge-warning">Chờ duyệt</span>
                                            @break
                                        @case('approved')
                                            <span class="badge badge-success">Đã duyệt</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge badge-danger">Từ chối</span>
                                            @break
                                    @endswitch
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Ngày nộp đơn:</strong></td>
                                <td>{{ $application->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @if($grade == 1)
                            <tr>
                                <td><strong>Đơn đăng ký:</strong></td>
                                <td>
                                    @if(!empty($application->registration_form_path))
                                        <a href="{{ route('admin.applications.download', ['type' => 'registration', 'id' => $application->id, 'grade' => 1]) }}" class="btn btn-sm btn-primary" target="_blank">
                                            <i class="fas fa-download"></i> Tải đơn đăng ký
                                        </a>
                                    @else
                                        <span class="text-muted">Chưa có file</span>
                                    @endif
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin gia đình -->
        @if($application->father_name || $application->mother_name || $application->guardian_name || $application->guardian_birthyear || $application->guardian_occupation)
        <div class="card mt-3">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-users"></i> Thông tin gia đình
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-male text-primary"></i> Thông tin Cha</h6>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td><strong>Họ tên:</strong></td>
                                <td>{{ $application->father_name ?? 'Không có thông tin' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Dân tộc:</strong></td>
                                <td>{{ $application->father_ethnicity ?? 'Không có thông tin' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Năm sinh:</strong></td>
                                <td>{{ $application->father_birthyear ?? 'Không có thông tin' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nghề nghiệp:</strong></td>
                                <td>{{ $application->father_occupation ?? 'Không có thông tin' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-female text-danger"></i> Thông tin Mẹ</h6>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td><strong>Họ tên:</strong></td>
                                <td>{{ $application->mother_name ?? 'Không có thông tin' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Dân tộc:</strong></td>
                                <td>{{ $application->mother_ethnicity ?? 'Không có thông tin' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Năm sinh:</strong></td>
                                <td>{{ $application->mother_birthyear ?? 'Không có thông tin' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nghề nghiệp:</strong></td>
                                <td>{{ $application->mother_occupation ?? 'Không có thông tin' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($application->guardian_name || $application->guardian_birthyear || $application->guardian_occupation)
                <div class="row mt-2">
                    <div class="col-md-12">
                        <h6><i class="fas fa-user-shield text-info"></i> Thông tin Người giám hộ</h6>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td><strong>Họ tên:</strong></td>
                                <td>{{ $application->guardian_name ?? 'Không có thông tin' }}</td>
                                <td><strong>Năm sinh:</strong></td>
                                <td>{{ $application->guardian_birthyear ?? 'Không có thông tin' }}</td>
                                <td><strong>Nghề nghiệp:</strong></td>
                                <td>{{ $application->guardian_occupation ?? 'Không có thông tin' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Kết quả học tập -->
        @if($grade == 6 || $grade == 10)
        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-graduation-cap"></i> Kết quả học tập các năm
                </h5>
            </div>
            <div class="card-body">
                @if($grade == 6)
                    <!-- Hiển thị kết quả lớp 1-5 cho đăng ký lớp 6 -->
                    <div class="row">
                        @for($i = 1; $i <= 5; $i++)
                            @php
                                $academicField = "grade{$i}_academic";
                                $conductField = "grade{$i}_conduct";
                            @endphp
                            @if($application->$academicField || $application->$conductField || ($i == 5 && ($application->grade5_math_avg || $application->grade5_literature_avg)))
                            <div class="col-md-4 mb-3">
                                <div class="card border-info">
                                    <div class="card-header bg-info text-white text-center">
                                        <h6 class="mb-0">Lớp {{ $i }}</h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <p class="mb-1"><strong>Học lực:</strong> {{ $application->$academicField ?? 'Chưa có' }}</p>
                                        <p class="mb-0"><strong>Hạnh kiểm:</strong> {{ $application->$conductField ?? 'Chưa có' }}</p>
                                        @if($i == 5)
                                            @if($application->grade5_math_avg)
                                                <p class="mt-1 mb-1 border-top pt-1"><strong>ĐTB Toán:</strong> {{ $application->grade5_math_avg }}</p>
                                            @endif
                                            @if($application->grade5_literature_avg)
                                                <p class="mb-0"><strong>ĐTB Tiếng Việt:</strong> {{ $application->grade5_literature_avg }}</p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endfor
                    </div>
                @elseif($grade == 10)
                    <!-- Hiển thị kết quả lớp 6-9 cho đăng ký lớp 10 -->
                    <div class="row">
                        @for($i = 6; $i <= 9; $i++)
                            @php
                                $academicField = "grade{$i}_academic";
                                $conductField = "grade{$i}_conduct";
                            @endphp
                            @if($application->$academicField || $application->$conductField || ($i == 9 && ($application->grade9_math_avg || $application->grade9_literature_avg)))
                            <div class="col-md-3 mb-3">
                                <div class="card border-success">
                                    <div class="card-header bg-success text-white text-center">
                                        <h6 class="mb-0">Lớp {{ $i }}</h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <p class="mb-1"><strong>Học lực:</strong> {{ $application->$academicField ?? 'Chưa có' }}</p>
                                        <p class="mb-1"><strong>Hạnh kiểm:</strong> {{ $application->$conductField ?? 'Chưa có' }}</p>
                                        @if($i == 9)
                                            @if($application->grade9_math_avg)
                                                <p class="mb-1"><strong>ĐTB Toán:</strong> {{ $application->grade9_math_avg }}</p>
                                            @endif
                                            @if($application->grade9_literature_avg)
                                                <p class="mb-0"><strong>ĐTB Văn:</strong> {{ $application->grade9_literature_avg }}</p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endfor
                    </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Thông tin đặc biệt -->
        @if(($grade == 10 || $grade == 6 || $grade == 1) && ($application->is_disabled || $application->achievements))
        <div class="card mt-3">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">
                    <i class="fas fa-star"></i> Thông tin đặc biệt
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @if($application->is_disabled)
                        <div class="mb-3">
                            <strong><i class="fas fa-wheelchair"></i> Người khuyết tật:</strong>
                            <span class="badge {{ $application->is_disabled == 'Không' ? 'badge-success' : 'badge-danger' }}">
                                {{ $application->is_disabled }}
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if($application->achievements)
                        <div class="mb-3">
                            <strong><i class="fas fa-trophy"></i> Giải thưởng:</strong>
                            <p class="mb-1">{{ $application->achievements }}</p>
                            @if($application->achievement_rank)
                                <small class="text-muted">Thành tích: {{ $application->achievement_rank }}</small>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Ghi chú -->
        @if($application->notes)
        <div class="card mt-3">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    <i class="fas fa-sticky-note"></i> Ghi chú
                </h5>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $application->notes }}</p>
            </div>
        </div>
        @endif
    </div>
</div>