<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotificationModel;

class Notifications extends BaseController
{
	/**
	 * Admin notifications page (existing behavior)
	 */
	public function index()
	{
		if (!session()->has('userID')) {
			return redirect()->to('/login');
		}

		$data = [
			'title' => 'Notifications',
			'user' => [
				'name' => session()->get('name'),
				'role' => session()->get('role'),
			],
		];

		return view('admin/notifications', $data);
	}

	/**
	 * JSON: get current user's notifications + unread count
	 */
	public function get()
	{
		if (!$this->isLoggedIn()) {
			return $this->response->setStatusCode(401)->setJSON([
				'status'  => 'error',
				'message' => 'Unauthorized',
			]);
		}

		$userId = $this->userData['id'];
		$notificationModel = new NotificationModel();

		$notifications = $notificationModel->getNotificationsForUser($userId, 5);
		$unreadCount  = $notificationModel->getUnreadCount($userId);

		return $this->response->setJSON([
			'status'        => 'success',
			'unread_count'  => $unreadCount,
			'notifications' => $notifications,
		]);
	}

	/**
	 * JSON: mark a notification as read for the current user
	 */
	public function mark_as_read($id = null)
	{
		if (!$this->isLoggedIn()) {
			return $this->response->setStatusCode(401)->setJSON([
				'status'  => 'error',
				'message' => 'Unauthorized',
			]);
		}

		$method = strtolower($this->request->getMethod());
		if (! in_array($method, ['post', 'get'], true)) {
			return $this->response->setStatusCode(405)->setJSON([
				'status'  => 'error',
				'message' => 'Method Not Allowed',
			]);
		}

		$id = (int) $id;
		if ($id <= 0) {
			return $this->response->setStatusCode(400)->setJSON([
				'status'  => 'error',
				'message' => 'Invalid notification ID',
			]);
		}

		$userId = $this->userData['id'];
		$notificationModel = new NotificationModel();

		// Ensure the notification belongs to the current user
		$notification = $notificationModel->where('id', $id)
			->where('user_id', $userId)
			->first();

		if (!$notification) {
			return $this->response->setStatusCode(404)->setJSON([
				'status'  => 'error',
				'message' => 'Notification not found',
			]);
		}

		// Explicitly update this notification as read
		$notificationModel->set('is_read', 1)
			->where('id', $id)
			->where('user_id', $userId)
			->update();

		$unreadCount = $notificationModel->getUnreadCount($userId);

		return $this->response->setJSON([
			'status'       => 'success',
			'unread_count' => $unreadCount,
		]);
	}
}
