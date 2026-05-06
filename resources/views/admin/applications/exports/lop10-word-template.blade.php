<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:x="urn:schemas-microsoft-com:office:excel"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
@verbatim
<!--[if gte mso 9]><xml>
 <x:ExcelWorkbook>
  <x:ExcelWorksheets>
   <x:ExcelWorksheet>
    <x:Name>Phieu xet tuyen lop 10</x:Name>
    <x:WorksheetOptions>
     <x:Print>
      <x:ValidPrinterInfo/>
      <x:PaperSizeIndex>9</x:PaperSizeIndex>
      <x:HorizontalResolution>600</x:HorizontalResolution>
      <x:VerticalResolution>600</x:VerticalResolution>
     </x:Print>
    </x:WorksheetOptions>
   </x:ExcelWorksheet>
  </x:ExcelWorksheets>
 </x:ExcelWorkbook>
</xml><![endif]-->
@endverbatim
<title>Phieu dang ki xet tuyen vao lop 10</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 13px;
            line-height: 1.35;
            margin: 10px;
            color: #000;
        }

        table.form {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }

        table.form td {
            border: none;
            padding: 1px 3px;
            vertical-align: top;
            font-size: 13px;
            word-wrap: break-word;
        }

        .center { text-align: center; }
        .right { text-align: right; }
        .bold { font-weight: 700; }
        .italic { font-style: italic; }
        .title { font-weight: 700; font-size: 13px; padding-top: 8px; }
        .subtitle { font-weight: 700; font-size: 13px; padding-top: 6px; }
        .spacer td { height: 6px; }
        .commit { text-align: justify; text-indent: 24px; }
        .meta { font-size: 12px; color: #444; padding-top: 8px; }

        .dots {
            display: inline-block;
            border-bottom: 1px dotted #000;
            width: 100%;
            height: 12px;
            vertical-align: baseline;
        }

        .dots-40 { width: 40%; }
        .dots-50 { width: 50%; }
        .dots-60 { width: 60%; }
        .dots-70 { width: 70%; }
        .dots-80 { width: 80%; }
        .dots-90 { width: 90%; }
    </style>
</head>
<body>
    <table class="form">
        <colgroup>
            <col span="9" style="width:50px;">
        </colgroup>

        <tr>
            <td colspan="9" class="italic">Mẫu Phiếu đăng kí xét tuyển vào lớp 10</td>
        </tr>

        <tr class="spacer"><td colspan="9"></td></tr>

        <tr>
            <td colspan="9" class="center bold">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</td>
        </tr>
        <tr>
            <td colspan="9" class="center bold">Độc lập - Tự do - Hạnh phúc</td>
        </tr>
        <tr>
            <td colspan="9" class="center">__________________________</td>
        </tr>

        <tr class="spacer"><td colspan="9"></td></tr>

        <tr>
            <td colspan="9" class="center title">PHIẾU ĐĂNG KÍ XÉT TUYỂN VÀO LỚP 10 NĂM HỌC 2026 -2027</td>
        </tr>
        <tr>
            <td colspan="9" class="center subtitle">Kính gửi: Hội đồng tuyển sinh Trường TH, THCS và THPT Thực hành Sư phạm</td>
        </tr>

        <tr>
            <td colspan="9">1) Họ và tên học sinh <span class="italic">(VIẾT CHỮ IN HOA)</span>: <span class="bold">{{ mb_strtoupper((string) ($application->fullname ?? ''), 'UTF-8') }}</span> <span class="dots dots-40"></span></td>
        </tr>
        <tr>
            <td colspan="6">'- Giới tính <span class="italic">(Nam/Nữ)</span>: {{ $application->gender ?? '' }} <span class="dots dots-50"></span></td>
            <td colspan="6">3) Dân tộc: {{ $application->ethnicity ?? '' }} <span class="dots dots-60"></span></td>
        </tr>
        <tr>
            <td colspan="9">'- Ngày tháng năm sinh: {{ optional($application->birthdate)->format('d/m/Y') }} <span class="dots dots-70"></span></td>
        </tr>
        <tr>
            <td colspan="9">'- Nơi sinh <span class="italic">(Tỉnh/Thành phố)</span>: <span class="dots"></span></td>
        </tr>
        <tr>
            <td colspan="9">'- Đối tượng chính sách <span class="italic">(Hộ nghèo/GĐ liệt sĩ/ GĐ có công với cách mạng/ GĐ có người là lão thành cách mạng/ GĐ tham gia kháng chiến...)</span>: <span class="dots"></span></td>
        </tr>
        <tr>
            <td colspan="9">'- Học sinh khuyết tật <span class="italic">(Ghi rõ dạng tật)</span>: {{ $application->is_disabled ?? '' }} <span class="dots dots-70"></span></td>
        </tr>
        <tr>
            <td colspan="9">'- Nơi thường trú <span class="italic">(Tổ, Khu, Phường/Xã, Tỉnh)</span>: {{ $application->address ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="9">'- Nơi ở hiện tại <span class="italic">(Số nhà, Tổ, Khu, Phường/Xã, Tỉnh)</span>: {{ $application->address ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="9">'- Số định danh cá nhân của học sinh <span class="italic">(Gồm 12 số do cơ quan Công an cấp)</span>: {{ $application->citizen_id ?? '' }} <span class="dots dots-50"></span></td>
        </tr>
        <tr>
            <td colspan="9">2) Được phân tuyển tuyển sinh vào: {{ $application->current_school ?? '' }} <span class="dots dots-50"></span></td>
        </tr>
        <tr>
            <td colspan="5">3) Họ tên cha: {{ $application->father_name ?? '' }} <span class="dots dots-60"></span></td>
            <td colspan="4">Năm sinh: <span class="dots dots-80"></span></td>
        </tr>
        <tr>
            <td colspan="5">'- Số điện thoại: {{ $application->phone ?? '' }} <span class="dots dots-60"></span></td>
            <td colspan="4">Nghề nghiệp: <span class="dots dots-70"></span></td>
        </tr>
        <tr>
            <td colspan="5">4) Họ tên mẹ: {{ $application->mother_name ?? '' }} <span class="dots dots-60"></span></td>
            <td colspan="4">Năm sinh: <span class="dots dots-80"></span></td>
        </tr>
        <tr>
            <td colspan="5">'- Số điện thoại: {{ $application->phone ?? '' }} <span class="dots dots-60"></span></td>
            <td colspan="4">Nghề nghiệp: <span class="dots dots-70"></span></td>
        </tr>
        <tr>
            <td colspan="5">5) Họ tên người giám hộ: <span class="dots dots-80"></span></td>
            <td colspan="4">Năm sinh: <span class="dots dots-80"></span></td>
        </tr>
        <tr>
            <td colspan="5">'- Số điện thoại: <span class="dots dots-80"></span></td>
            <td colspan="4">Nghề nghiệp: <span class="dots dots-70"></span></td>
        </tr>
        <tr>
            <td colspan="5">6) Số điện thoại liên hệ: {{ $application->phone ?? '' }} <span class="dots dots-40"></span></td>
            <td colspan="4">Email (nếu có): <span class="dots dots-70"></span></td>
        </tr>
        <tr>
            <td colspan="9" class="commit">
                Cha mẹ/người giám hộ học sinh cam kết những thông tin kê khai trong phiếu này là đúng sự thật; nếu không đúng cha mẹ/ người giám hộ học sinh hoàn toàn chịu trách nhiệm về kết quả của học sinh. Gia đình cam kết cho con tham gia học tập đầy đủ các nội dung theo chương trình Giáo dục phổ thông hiện hành và các chương trình giáo dục thực nghiệm sư phạm theo kế hoạch giáo dục của nhà trường.
            </td>
        </tr>
        <tr>
            <td colspan="9" style="padding-left: 24px;">Trân trọng cảm ơn!</td>
        </tr>

        <tr class="spacer"><td colspan="9"></td></tr>

        <tr>
            <td colspan="4" class="center bold">CHA MẸ/ NGƯỜI GIÁM HỘ  HỌC SINH</td>
            <td></td>
            <td colspan="4" class="center italic">........, ngày ..... tháng .......... năm 2026</td>
        </tr>
        <tr>
            <td colspan="4" class="center italic">(Ký và ghi rõ họ tên)</td>
            <td></td>
            <td colspan="4" class="center bold">NGƯỜI NHẬN HỒ SƠ</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td></td>
            <td colspan="4" class="center italic">(ký và ghi rõ họ tên)</td>
        </tr>

        <tr class="spacer"><td colspan="9"></td></tr>

        <tr>
            <td colspan="9" class="meta">Mã hồ sơ: {{ $application->id }} | Xuất lúc: {{ $exportedAt->format('d/m/Y H:i:s') }}</td>
        </tr>
    </table>
</body>
</html>
