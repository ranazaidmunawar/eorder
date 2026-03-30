<?php

namespace App\Constants;

use App\Models\User;

class UserEmailTemplate
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUserMailTemplate(): array
    {
        return
            [
                [
                    'user_id' => $this->user->id,
                    'mail_type' => 'verify_email',
                    'mail_subject' => 'Verify Your Email Address',
                    'mail_body' => '<p>Hi <b>{username}</b>,</p><p>We just need to verify your email address before you can access to your dashboard.</p><p>Verify your email address, {verification_link}.</p><p>Thank you.<br>{website_title}</p>'
                ],
                [
                    'user_id' => $this->user->id,
                    'mail_type' => 'reset_password',
                    'mail_subject' => 'Recover Password of Your Account',
                    'mail_body' => '<p>Hi {customer_name},</p><p>We have received a request to reset your password. If you did not make the request, just ignore this email. Otherwise, you can reset your password using this below link.</p><p>{password_reset_link}</p><p>Thanks,<br>{website_title}</p>'
                ],
              
                [
                    'user_id' => $this->user->id,
                    'mail_type' => 'order_received',
                    'mail_subject' => 'Order Received',
                    'mail_body' => "<p style='line-height: 1.6;'>Hello {customer_name},</p><p style='line-height: 1.6;'><br>Your order has been received.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>"
                ],
                [
                    'user_id' => $this->user->id,
                    'mail_type' => 'order_preparing',
                    'mail_subject' => 'Preparing Your Order',
                    'mail_body' => "<p style='line-height: 1.6;'>Hello {customer_name},</p><p style='line-height: 1.6;'><br>Chef has started preparing your ordered foods.<br>Order Number:&nbsp; #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>"
                ],
                [
                    'user_id' => $this->user->id,
                    'mail_type' => 'order_ready_to_pickup',
                    'mail_subject' => 'Your Order is Ready to Pickup',
                    'mail_body' => "<p style='line-height: 1.6;'>Hello {customer_name},</p><p style='line-height: 1.6;'><br>Your order is ready to pick up. Please pick up your order at your chosen date &amp; time.<br>Order Number:&nbsp; #{order_number}</p><p style='line-height: 1.6;'><br>{text}<br>{order_link}</p><p style='line-height: 1.6;'><br></p><p>Best Regards,<br>{website_title}</p>"
                ],
                [
                    'user_id' => $this->user->id,
                    'mail_type' => 'order_pickup',
                    'mail_subject' => 'Order has been picked up',
                    'mail_body' => "<p>Hello {customer_name},</p><p><br>Your order is picked up for delivery. It will arrive in a few moments.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>"
                ],
                [
                    'user_id' => $this->user->id,
                    'mail_type' => 'order_pickedup_pick_up',
                    'mail_subject' => 'You have picked up Ordered Food',
                    'mail_body' => "<p>Hello {customer_name},</p><p><br>You have picked up your ordered Food.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>"
                ],
                [
                    'user_id' => $this->user->id,
                    'mail_type' => 'order_delivered',
                    'mail_subject' => 'Order has been Delivered',
                    'mail_body' => "<p style='line-height: 1.6;'>Hello {customer_name},</p><p style='line-height: 1.6;'><br>Your order has been delivered.<br>Order Number: #{order_number}</p><p style='line-height: 1.6;'><br>{text}<br>{order_link}</p><p style='line-height: 1.6;'><br></p><p>Best Regards,<br>{website_title}</p>"
                ],
                [
                    'user_id' => $this->user->id,
                    'mail_type' => "order_cancelled",
                    'mail_subject' => "Order is Cancelled",
                    'mail_body' => "<p style='line-height: 1.6;'>Hello&nbsp;<span style='font-weight: 600;'>{customer_name}</span>,</p><p style='line-height: 1.6;'><br>Your order has been canceled.<br>Order Number: {order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br><span style='font-weight: 600;'>{website_title}</span></p>",
                ],
                [
                    'user_id' => $this->user->id,
                    'mail_type' => "order_ready_to_serve",
                    'mail_subject' => "Your order is ready to serve on table",
                    'mail_body' => "<p>Hello {customer_name},</p><p><br>Your order is served at your table. Enjoy your Food.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>",
                ],
                [
                    'user_id' => $this->user->id,
                    'mail_type' => "order_served",
                    'mail_subject' => "You order is served on table",
                    'mail_body' => "<p>Hello {customer_name},</p><p><br>Your order is served at your table. Enjoy your Food.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>",
                ],
                [
                    'user_id' => $this->user->id,
                    'mail_type' => "food_checkout",
                    'mail_subject' => "Order has been placed",
                    'mail_body' => "<p style='line-height: 1.6;'>Hello {customer_name},</p><p style='line-height: 1.6;'><br>Your order has been placed successfully.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>",
                ],
                [
                    'user_id' => $this->user->id,
                    'mail_type' => "reservation_accept",
                    'mail_subject' => "Reservation Request Accepted",
                    'mail_body' => "<p>Hello {customer_name},</p><p><br>Your reservation request has been accepted.</p><p><br></p><p>Best Regards,<br>{website_title}</p>",
                ],
                [
                    'user_id' => $this->user->id,
                    'mail_type' => "reservation_reject",
                    'mail_subject' => "Reservation Request Rejected",
                    'mail_body' => "<p style='line-height: 1.6;'>Hello {customer_name},</p><p style='line-height: 1.6;'><br>Your reservation request has been rejected.</p><p><br></p><p>Best Regards,<br>{website_title}</p>",
                ],
                [
                    'user_id' => $this->user->id,
                    'mail_type' => "order_ready_to_pickup_pick_up",
                    'mail_subject' => "Your order is ready to pick up",
                    'mail_body' => "<p style='line-height: 1.6;'>Hello {customer_name},</p><p style='line-height: 1.6;'><br>Your order is ready to pick up. Please pick up your order at your chosen date &amp; time.<br>Order Number:&nbsp; #{order_number}</p><p style='line-height: 1.6;'><br>{text}<br>{order_link}</p><p style='line-height: 1.6;'><br></p><p>Best Regards,<br>{website_title}</p>",
                ]
            ];
    }
}


