<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
</head>

<body
    style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f4f4f4;">

    <table
        style="max-width: 600px; margin: 0 auto; background: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden;">
        <!-- Header -->
        <tr>
            <td
                style="background: linear-gradient(135deg, #006738, #22c55e); color: white; padding: 30px 20px; text-align: center;">
                <h1 style="margin: 0 0 10px 0; font-size: 24px; font-weight: bold;">New Contact Form Submission</h1>
                <p style="margin: 0; color: #e0f2e0;">BriliantMath Learning Platform</p>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 30px 20px;">

                <!-- Name -->
                <div
                    style="margin-bottom: 20px; padding: 15px; border-left: 4px solid #006738; background-color: #f9f9f9; border-radius: 0 4px 4px 0;">
                    <strong style="color: #006738; display: block; margin-bottom: 5px; font-size: 14px;">Name:</strong>
                    <span style="color: #555;">{{ $formData['first_name'] }} {{ $formData['last_name'] }}</span>
                </div>

                <!-- Email -->
                <div
                    style="margin-bottom: 20px; padding: 15px; border-left: 4px solid #006738; background-color: #f9f9f9; border-radius: 0 4px 4px 0;">
                    <strong style="color: #006738; display: block; margin-bottom: 5px; font-size: 14px;">Email:</strong>
                    <a href="mailto:{{ $formData['email'] }}"
                        style="color: #006738; text-decoration: none;">{{ $formData['email'] }}</a>
                </div>

                @if (!empty($formData['phone']))
                    <!-- Phone -->
                    <div
                        style="margin-bottom: 20px; padding: 15px; border-left: 4px solid #006738; background-color: #f9f9f9; border-radius: 0 4px 4px 0;">
                        <strong
                            style="color: #006738; display: block; margin-bottom: 5px; font-size: 14px;">Phone:</strong>
                        <a href="tel:{{ $formData['phone'] }}"
                            style="color: #006738; text-decoration: none;">{{ $formData['phone'] }}</a>
                    </div>
                @endif

                @if (!empty($formData['student_level']))
                    <!-- Student Level -->
                    <div
                        style="margin-bottom: 20px; padding: 15px; border-left: 4px solid #006738; background-color: #f9f9f9; border-radius: 0 4px 4px 0;">
                        <strong style="color: #006738; display: block; margin-bottom: 5px; font-size: 14px;">Student
                            Level:</strong>
                        <span style="color: #555;">
                            @switch($formData['student_level'])
                                @case('primary')
                                    Primary (Ages 5-11)
                                @break

                                @case('secondary')
                                    Secondary (Ages 11-18)
                                @break

                                @case('adult')
                                    Adult Learner
                                @break

                                @case('teacher')
                                    Teacher/Educator
                                @break

                                @default
                                    {{ ucfirst($formData['student_level']) }}
                            @endswitch
                        </span>
                    </div>
                @endif

                <!-- Inquiry Type -->
                <div
                    style="margin-bottom: 20px; padding: 15px; border-left: 4px solid #006738; background-color: #f9f9f9; border-radius: 0 4px 4px 0;">
                    <strong style="color: #006738; display: block; margin-bottom: 5px; font-size: 14px;">Inquiry
                        Type:</strong>
                    <span style="color: #555;">
                        @switch($formData['inquiry_type'])
                            @case('online_courses')
                                Online Courses Information
                            @break

                            @case('live_classes')
                                Live Online Classes
                            @break

                            @case('physical_classes')
                                Physical Classes (Labone Campus)
                            @break

                            @case('teacher_training')
                                Teacher Training & Seminars
                            @break

                            @case('textbooks')
                                BriliantMath Textbooks
                            @break

                            @case('curriculum')
                                Curriculum Consulting
                            @break

                            @case('general')
                                General Information
                            @break

                            @case('other')
                                Other
                            @break

                            @default
                                {{ ucfirst(str_replace('_', ' ', $formData['inquiry_type'])) }}
                        @endswitch
                    </span>
                </div>

                <!-- Message -->
                <div
                    style="margin-bottom: 20px; padding: 15px; border-left: 4px solid #006738; background-color: #f9f9f9; border-radius: 0 4px 4px 0;">
                    <strong
                        style="color: #006738; display: block; margin-bottom: 10px; font-size: 14px;">Message:</strong>
                    <div
                        style="background-color: white; border: 1px solid #dee2e6; border-radius: 4px; padding: 15px; margin-top: 5px;">
                        <p style="margin: 0; color: #555; line-height: 1.5;">{{ $formData['message'] }}</p>
                    </div>
                </div>

                @if ($formData['newsletter'] ?? false)
                    <!-- Newsletter -->
                    <div
                        style="margin-bottom: 20px; padding: 15px; border-left: 4px solid #22c55e; background-color: #f0f9f0; border-radius: 0 4px 4px 0;">
                        <strong style="color: #22c55e; display: block; margin-bottom: 5px; font-size: 14px;">Newsletter
                            Subscription:</strong>
                        <span style="color: #16a34a;">✅ Yes, wants to receive updates and offers</span>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div style="margin: 30px 0; text-align: center;">
                    <table style="margin: 0 auto;">
                        <tr>
                            <td style="padding-right: 10px;">
                                <a href="mailto:{{ $formData['email'] }}"
                                    style="display: inline-block; padding: 12px 24px; background-color: #006738; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 14px;">
                                    Reply to {{ $formData['first_name'] }}
                                </a>
                            </td>
                            @if (!empty($formData['phone']))
                                <td style="padding-left: 10px;">
                                    <a href="tel:{{ $formData['phone'] }}"
                                        style="display: inline-block; padding: 12px 24px; border: 2px solid #006738; color: #006738; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 14px;">
                                        Call Now
                                    </a>
                                </td>
                            @endif
                        </tr>
                    </table>
                </div>

            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="padding: 20px; border-top: 1px solid #eee; text-align: center; background-color: #fafafa;">
                <p style="margin: 0 0 10px 0; color: #666; font-size: 12px;">
                    This email was sent from the BriliantMath contact form on {{ now()->format('F j, Y \a\t g:i A') }}
                </p>
                <p style="margin: 0; color: #006738; font-weight: bold; font-size: 13px;">
                    Please respond within 24 hours as promised on the website.
                </p>
            </td>
        </tr>
    </table>

</body>

</html>
