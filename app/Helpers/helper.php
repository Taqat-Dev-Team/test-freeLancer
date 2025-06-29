    <?php
    function otp(): int
    {
        return 111111;
    //    rand(100000, 999999); // إنشاء رمز OTP من 6 أرقام

    }


    function languages_levels()
    {
        return collect([
            ['key' => 0, 'label' => __('messages.beginner')],
            ['key' => 1, 'label' => __('messages.intermediate')],
            ['key' => 2, 'label' => __('messages.advanced')],
            ['key' => 3, 'label' => __('messages.native')],
        ]);
    }

    function work_type()
    {
        return collect([
            ['key' => 'on-site', 'label' => __('messages.on-site')],
            ['key' => 'remote', 'label' => __('messages.remote')],
            ['key' => 'hybrid', 'label' => __('messages.hybrid')],
        ]);
    }

    function AcademicGrade()
    {
        return collect([
            ['key' => 'excellent', 'label' => __('messages.excellent')],
            ['key' => 'very_good', 'label' => __('messages.very_good')],
            ['key' => 'good', 'label' => __('messages.good')],
            ['key' => 'pass', 'label' => __('messages.pass')]

        ]);

    }


    function unreadContactsCount()
    {
        return \App\Models\Contact::where('status', 0)->count();
    }

    function IdentityRequestsCount()
    {
        return \App\Models\IdentityVerification::where('status', '0')->count();
    }
