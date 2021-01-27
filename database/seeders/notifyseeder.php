<?php

namespace Database\Seeders;

use App\Models\Notifications;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class notifyseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $orders = Order::all();
        // $user = User::where('status', 0)->first();
        // $employee = User::where('status', 1)->first();
        // $admin = User::where('status', 2)->first();
        // foreach ($orders as $order) {
        //     Notifications::create([
        //         'type' => 0,
        //         'name' => 'انشاء يوزر اودر',
        //         'description' => 'تم انشائ حجز من قبل مستخدم ',
        //         'order_id' => $order->id,
        //         'to_user' => $employee->id,
        //         'from_user' => $user->id,

        //     ]);
        //     Notifications::create([
        //         'type' => 1,
        //         'name' => 'الموضف رد ع اليوزر يامطي ',
        //         'description' => ' رد من قبل الموضف  ',
        //         'order_id' => $order->id,
        //         'to_user' => $user->id,
        //         'from_user' => $employee->id,

        //     ]);
        // }
        // Notifications::create([
        //     'type' => 2,
        //     'name' => 'المدير يدز للموضف ',
        //     'description' => 'المدير يدز  ',
        //     'to_user' => $employee->id,
        //     'from_user' => $admin->id,

        // ]);
        // $allusers = User::select('id')->get();
        // foreach ($allusers as $user) {

        //     Notifications::create([
        //         'type' => 3,
        //         'name' => 'لكل اليوزر ',
        //         'description' => 'لكل اليوزر   ',
        //         'to_user' => $user->id,
        //         'from_user' => $admin->id,

        //     ]);
        // }
    }
}
