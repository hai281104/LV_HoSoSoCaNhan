<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    protected $apiKey;
    protected $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
    }

    protected function callGemini(string $prompt, ?string $imagePath = null)
    {
        if (empty($this->apiKey)) {
            Log::warning('GEMINI_API_KEY is missing.');
            return null;
        }

        $parts = [
            ['text' => $prompt]
        ];

        if ($imagePath && file_exists($imagePath)) {
            $imageData = base64_encode(file_get_contents($imagePath));
            $mimeType = @mime_content_type($imagePath) ?: 'image/jpeg';
            $parts[] = [
                'inline_data' => [
                    'mime_type' => $mimeType,
                    'data' => $imageData
                ]
            ];
        }

        $response = Http::withoutVerifying()->timeout(120)->withHeaders([
            'Content-Type' => 'application/json',
        ])->post($this->endpoint . '?key=' . $this->apiKey, [
            'contents' => [
                [
                    'parts' => $parts
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'response_mime_type' => 'application/json',
            ]
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
            if ($text) {
                $cleanedText = preg_replace('/^```(?:json)?\s*|\s*```$/iu', '', trim($text));
                $decoded = json_decode($cleanedText, true);
                if ($decoded) {
                    return $decoded;
                }
                if (preg_match('/\{[\s\S]*\}/u', $cleanedText, $matches)) {
                    $decodedRegex = json_decode($matches[0], true);
                    if ($decodedRegex) {
                        return $decodedRegex;
                    }
                }
            }
        }

        Log::error('Gemini API Error: ' . $response->body());
        return null;
    }

    public function generateCv(string $userPrompt, array $profileData)
    {
        $profileJson = json_encode($profileData, JSON_UNESCAPED_UNICODE);
        
        $prompt = "Bạn là một chuyên gia tạo CV (Sơ yếu lý lịch) chuyên nghiệp.\n";
        $prompt .= "Tôi sẽ cung cấp cho bạn thông tin hồ sơ hiện có của một người dùng và một yêu cầu bổ sung.\n";
        $prompt .= "Nhiệm vụ của bạn là kết hợp chúng lại để tạo ra một cấu trúc CV hoàn chỉnh, hấp dẫn nhà tuyển dụng, theo định dạng JSON.\n\n";
        
        $prompt .= "THÔNG TIN HỒ SƠ:\n" . $profileJson . "\n\n";
        $prompt .= "YÊU CẦU CỦA NGƯỜI DÙNG: " . $userPrompt . "\n\n";
        
        $prompt .= "ĐỊNH DẠNG ĐẦU RA JSON BẮT BUỘC:\n";
        $prompt .= "{\n";
        $prompt .= '  "tieu_de": "Tên CV (VD: CV Ứng tuyển Backend Developer)",' . "\n";
        $prompt .= '  "ma_template": "Trích xuất từ yêu cầu của người dùng, nếu không rõ trả về \'template_classic\'. (Chỉ được chọn \'template_classic\' hoặc \'template_modern\')",' . "\n";
        $prompt .= '  "mau_chu_dao": "Trích xuất mã màu Hex (VD: #2563eb) từ yêu cầu của người dùng, nếu không có hãy chọn màu mặc định #1e3a8a",' . "\n";
        $prompt .= '  "muc_tieu_nghe_nghiep": "Mục tiêu nghề nghiệp ngắn gọn, hấp dẫn, khoảng 3-4 câu.",' . "\n";
        $prompt .= '  "kinh_nghiem": "Mô tả chi tiết kinh nghiệm làm việc bằng Markdown hoặc HTML list.",' . "\n";
        $prompt .= '  "hoc_van": "Mô tả chi tiết học vấn bằng Markdown hoặc HTML list.",' . "\n";
        $prompt .= '  "ky_nang": "Danh sách các kỹ năng chuyên môn và kỹ năng mềm.",' . "\n";
        $prompt .= '  "du_an": "Mô tả các dự án đã tham gia.",' . "\n";
        $prompt .= '  "chung_chi": "Danh sách các chứng chỉ.",' . "\n";
        $prompt .= '  "hoat_dong": "Các hoạt động xã hội hoặc ngoại khóa."' . "\n";
        $prompt .= "}\n";
        
        $prompt .= "Chỉ trả về JSON thuần túy, không có Markdown formatting như ```json.";

        return $this->callGemini($prompt);
    }

    public function improveText(string $text)
    {
        $prompt = "Bạn là một chuyên gia nhân sự và viết lách chuyên nghiệp.\n";
        $prompt .= "Hãy viết lại và làm nổi bật đoạn văn bản sau đây để nó trông thật ấn tượng, chuyên nghiệp, sửa lỗi chính tả và phù hợp cho một CV xin việc.\n";
        $prompt .= "Đoạn văn bản gốc:\n" . $text . "\n\n";
        
        $prompt .= "ĐỊNH DẠNG ĐẦU RA JSON BẮT BUỘC:\n";
        $prompt .= "{\n";
        $prompt .= '  "improved_text": "Văn bản đã được chỉnh sửa (có thể xuống dòng, hoặc dùng danh sách gạch đầu dòng)"' . "\n";
        $prompt .= "}\n";
        
        $prompt .= "Chỉ trả về JSON thuần túy, không có Markdown formatting như ```json.";

        $result = $this->callGemini($prompt);
        return $result['improved_text'] ?? $text;
    }

    public function evaluateCv(array $cvData)
    {
        $cvJson = json_encode($cvData, JSON_UNESCAPED_UNICODE);
        
        $prompt = "Bạn là một Giám đốc nhân sự (HR Director) kỳ cựu với 15 năm kinh nghiệm.\n";
        $prompt .= "Hãy đánh giá hồ sơ ứng viên (CV) sau đây, chấm điểm trên 100 và đưa ra nhận xét chuyên sâu.\n\n";
        $prompt .= "THÔNG TIN CV:\n" . $cvJson . "\n\n";
        
        $prompt .= "ĐỊNH DẠNG ĐẦU RA JSON BẮT BUỘC:\n";
        $prompt .= "{\n";
        $prompt .= '  "diem": "Điểm số từ 0 đến 100",' . "\n";
        $prompt .= '  "uu_diem": ["Điểm mạnh 1", "Điểm mạnh 2"],' . "\n";
        $prompt .= '  "nhuoc_diem": ["Điểm yếu 1", "Điểm yếu 2"],' . "\n";
        $prompt .= '  "de_xuat_cai_thien": ["Lời khuyên 1", "Lời khuyên 2"]' . "\n";
        $prompt .= "}\n";
        
        $prompt .= "Chỉ trả về JSON thuần túy, không có Markdown formatting như ```json.";

        return $this->callGemini($prompt);
    }

    public function generateCvTemplateCode(string $userPrompt, ?string $imagePath = null)
    {
        $prompt = "Bạn là một lập trình viên Frontend và Designer chuyên nghiệp về viết mã giao diện CV (Sơ yếu lý lịch) trong Laravel Blade.\n";
        if ($imagePath) {
            $prompt .= "Tôi đã đính kèm HÌNH ẢNH MẪU THIẾT KẾ CV. Hãy phân tích hình ảnh này (bố cục 1 hoặc 2 cột, màu sắc, phông chữ, các đường phân cách...) và viết mã Blade HTML mô phỏng lại thiết kế từ hình ảnh này càng giống càng tốt.\n";
        }
        $prompt .= "Hãy viết mã nguồn HTML / Blade View hoàn chỉnh cho mẫu CV dựa trên các yêu cầu sau:\n";
        $prompt .= "YÊU CẦU BỔ SUNG / MÔ TẢ: " . ($userPrompt ?: "Mô phỏng lại thiết kế từ hình ảnh mẫu được đính kèm.") . "\n\n";

        $prompt .= "QUY TẮC NGUYÊN TẮC MÃ NGUỒN BẮT BUỘC (RẤT QUAN TRỌNG):\n";
        $prompt .= "1. KHÔNG ĐƯỢC CHÈN các thẻ <!DOCTYPE html>, <html>, <head>, <body>! Mẫu CV này được nhúng trực tiếp bằng @include vào container. Hãy bắt đầu file bằng thẻ <style>...</style> chứa CSS, sau đó là <div class=\"cv-document\">...</div> chứa toàn bộ nội dung.\n";
        $prompt .= "2. Sử dụng đúng các biến Laravel Blade chính xác sau đây (CHÚ Ý TÊN BIẾN CÓ CHỮ HOA TƯƠNG ỨNG):\n";
        $prompt .= "   - \$profileData['nguoiDung']->ho_ten (Họ và tên người dùng)\n";
        $prompt .= "   - \$profileData['nguoiDung']->chuc_danh (Chức danh chuyên môn)\n";
        $prompt .= "   - \$profileData['nguoiDung']->email (Email)\n";
        $prompt .= "   - \$profileData['nguoiDung']->so_dien_thoai (Số điện thoại)\n";
        $prompt .= "   - \$profileData['nguoiDung']->dia_chi (Địa chỉ)\n";
        $prompt .= "   - \$profileData['nguoiDung']->anh_dai_dien (URL ảnh đại diện)\n";
        $prompt .= "   - \$profileData['nguoiDung']->gioi_thieu (Mô tả bản thân)\n";
        $prompt .= "   - \$profileData['kinhNghiem'] (Danh sách kinh nghiệm. Lặp bằng @foreach(\$profileData['kinhNghiem'] as \$item) -> \$item->ten_cong_ty, vị trí: \$item->vi_tri_cong_viec ?? \$item->chuc_vu, \$item->ngay_bat_dau, \$item->ngay_ket_thuc, mô tả: \$item->mo_ta_chi_tiet ?? \$item->mo_ta)\n";
        $prompt .= "   - \$profileData['hocVan'] (Danh sách học vấn. Lặp bằng @foreach(\$profileData['hocVan'] as \$item) -> \$item->ten_truong, ngành: \$item->nganh ?? \$item->tieu_de, \$item->nam_bat_dau, \$item->nam_ket_thuc, \$item->mo_ta)\n";
        $prompt .= "   - \$profileData['kyNang'] (Mảng các tên kỹ năng mềm string. Lặp bằng @foreach(\$profileData['kyNang'] as \$skill))\n";
        $prompt .= "   - \$profileData['ngonNgu'] (Mảng các tên ngôn ngữ lập trình string. Lặp bằng @foreach(\$profileData['ngonNgu'] as \$lang))\n";
        $prompt .= "   - \$profileData['duAn'] (Danh sách dự án. Lặp bằng @foreach(\$profileData['duAn'] as \$item) -> \$item->ten_du_an, vai trò: \$item->vai_tro, mô tả: \$item->mo_ta_chi_tiet ?? \$item->mo_ta, \$item->lien_ket)\n";
        $prompt .= "   - \$profileData['chungChi'] (Danh sách chứng chỉ. Lặp bằng @foreach(\$profileData['chungChi'] as \$item) -> \$item->ten_chung_chi, \$item->to_chuc_cap, \$item->ngay_cap)\n";
        $prompt .= "   - \$profileData['thanhTuu'] (Danh sách thành tựu. Lặp bằng @foreach(\$profileData['thanhTuu'] as \$item) -> \$item->ten_thanh_tuu, \$item->mo_ta)\n";
        $prompt .= "   - \$profileData['lienKetMxh'] (Danh sách MXH. Lặp bằng @foreach(\$profileData['lienKetMxh'] as \$item) -> \$item->ten_nen_tang, \$item->duong_dan)\n";
        $prompt .= "   - \$tuyChinh['mau_chu_dao'] (Mã màu Hex chủ đạo, ví dụ {{ \$tuyChinh['mau_chu_dao'] ?? '#1e3a8a' }})\n";
        $prompt .= "3. Luôn bọc kiểm tra @if(!empty(...)) trước khi lặp các danh sách.\n";
        $prompt .= "4. CSS phải thiết kế responsive, thanh lịch, trình bày thông tin đẹp mắt và chuyên nghiệp.\n\n";

        $prompt .= "ĐỊNH DẠNG ĐẦU RA JSON BẮT BUỘC:\n";
        $prompt .= "{\n";
        $prompt .= '  "blade_code": "Mã nguồn Blade View hoàn chỉnh từ <style> đến hết các div nội dung"' . "\n";
        $prompt .= "}\n";

        $prompt .= "Chỉ trả về JSON thuần túy, không có Markdown formatting như ```json.";

        $result = $this->callGemini($prompt, $imagePath);
        return $result['blade_code'] ?? null;
    }
}
