<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AlbumValidationTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Lấy user test
        $this->user = User::where('email', 'test@gmail.com')->first();
    }

    /**
     * Test validation thất bại khi Tên sự kiện trống.
     */
    public function test_validation_fails_when_ten_su_kien_is_empty()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.album.luu'), [
                'ten_su_kien' => '',
                'ngay_su_kien' => '2026-06-17',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ten_su_kien']);
    }

    /**
     * Test validation thất bại khi Tên sự kiện chứa ký tự đặc biệt lạ.
     */
    public function test_validation_fails_when_ten_su_kien_has_special_characters()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.album.luu'), [
                'ten_su_kien' => 'Hội thảo AI @ 2026',
                'ngay_su_kien' => '2026-06-17',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ten_su_kien']);
    }

    /**
     * Test validation thất bại khi Tên sự kiện quá ngắn (1 ký tự) hoặc quá dài (101 ký tự).
     */
    public function test_validation_fails_when_ten_su_kien_length_out_of_bounds()
    {
        // Quá ngắn
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.album.luu'), [
                'ten_su_kien' => 'A',
                'ngay_su_kien' => '2026-06-17',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ten_su_kien']);

        // Quá dài
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.album.luu'), [
                'ten_su_kien' => str_repeat('A', 101),
                'ngay_su_kien' => '2026-06-17',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ten_su_kien']);
    }

    /**
     * Test validation thất bại khi Ngày sự kiện trống.
     */
    public function test_validation_fails_when_ngay_su_kien_is_empty()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.album.luu'), [
                'ten_su_kien' => 'Hội thảo công nghệ',
                'ngay_su_kien' => '',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ngay_su_kien']);
    }

    /**
     * Test validation thất bại khi Mô tả quá dài (1001 ký tự).
     */
    public function test_validation_fails_when_mo_ta_is_too_long()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.album.luu'), [
                'ten_su_kien' => 'Hội thảo công nghệ',
                'ngay_su_kien' => '2026-06-17',
                'mo_ta' => str_repeat('A', 1001),
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['mo_ta']);
    }

    /**
     * Test validation thất bại khi không tải ảnh nào lên.
     */
    public function test_validation_fails_when_no_images_uploaded()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.album.luu'), [
                'ten_su_kien' => 'Hội thảo công nghệ',
                'ngay_su_kien' => '2026-06-17',
                'anh_moi' => [],
                'anh_cu' => [],
            ]);

        $response->assertStatus(422);
        $response->assertJson(['thanh_cong' => false, 'thong_bao' => 'Sự kiện phải có tối thiểu 1 ảnh minh họa.']);
    }

    /**
     * Test validation thất bại khi tải lên nhiều hơn 5 ảnh.
     */
    public function test_validation_fails_when_more_than_five_images_uploaded()
    {
        $images = [
            UploadedFile::fake()->image('image1.jpg'),
            UploadedFile::fake()->image('image2.jpg'),
            UploadedFile::fake()->image('image3.jpg'),
            UploadedFile::fake()->image('image4.jpg'),
            UploadedFile::fake()->image('image5.jpg'),
            UploadedFile::fake()->image('image6.jpg'),
        ];

        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.album.luu'), [
                'ten_su_kien' => 'Hội thảo công nghệ',
                'ngay_su_kien' => '2026-06-17',
                'anh_moi' => $images,
            ]);

        $response->assertStatus(422);
        $response->assertJson(['thanh_cong' => false, 'thong_bao' => 'Sự kiện chỉ được có tối đa 5 ảnh minh họa.']);
    }

    /**
     * Test validation thất bại khi định dạng ảnh không đúng.
     */
    public function test_validation_fails_when_image_type_invalid()
    {
        $images = [
            UploadedFile::fake()->create('document.pdf', 100),
        ];

        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.album.luu'), [
                'ten_su_kien' => 'Hội thảo công nghệ',
                'ngay_su_kien' => '2026-06-17',
                'anh_moi' => $images,
            ]);

        $response->assertStatus(422);
        $response->assertJson(['thanh_cong' => false, 'thong_bao' => 'Định dạng ảnh không hợp lệ. Chỉ hỗ trợ JPG, PNG, WebP.']);
    }

    /**
     * Test validation thất bại khi dung lượng ảnh vượt quá 2MB.
     */
    public function test_validation_fails_when_image_size_exceeds_limit()
    {
        // Tạo file ảnh giả lập vượt quá 2MB (2049 KB)
        $images = [
            UploadedFile::fake()->create('large_image.jpg', 2049, 'image/jpeg'),
        ];

        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.album.luu'), [
                'ten_su_kien' => 'Hội thảo công nghệ',
                'ngay_su_kien' => '2026-06-17',
                'anh_moi' => $images,
            ]);

        $response->assertStatus(422);
        $response->assertJson(['thanh_cong' => false, 'thong_bao' => 'Dung lượng mỗi ảnh không được vượt quá 2MB.']);
    }

    /**
     * Test validation thành công khi mọi dữ liệu đều hợp lệ.
     */
    public function test_validation_passes_when_data_is_valid()
    {
        $images = [
            UploadedFile::fake()->image('image1.jpg'),
            UploadedFile::fake()->image('image2.png'),
        ];

        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.album.luu'), [
                'ten_su_kien' => 'Bảo vệ đồ án tốt nghiệp',
                'ngay_su_kien' => '2026-06-15',
                'mo_ta' => 'Một ngày tuyệt vời với bạn bè và gia đình.',
                'anh_moi' => $images,
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);
    }
}
