<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderProcessingNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Mengambil pesanan dengan status "processing"
        $processingOrders = Order::where('status', 'processing')->get();

        $mailMessage = (new MailMessage)
            ->subject('Pesanan dengan Status Proses')
            ->line('Terdapat pesanan dengan status "proses" yang memerlukan perhatian.')
            ->line('Berikut rincian pesanannya:');

        // Melakukan perulangan melalui setiap pesanan yang sedang diproses dan menambahkan rincian ke email
        foreach ($processingOrders as $order) {
            $orderDetails = "ID Pesanan: {$order->id}, Total Harga: Rp " . number_format($order->total_amount, 0, ',', '.');
            $mailMessage->line($orderDetails);
        }

        // Menambahkan tautan ke kelola pesanan di admin
        $adminManageOrdersUrl = route('admin.orders.index');
        $mailMessage->action('Kelola Pesanan di Admin', $adminManageOrdersUrl);

        return $mailMessage->line('Terima kasih telah menggunakan aplikasi kami!');
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
