<?php
/**
 * File name: UserRepository.php
 * Last modified: 16/07/21, 6:25 PM
 * Author: NearCraft - https://codecanyon.net/user/nearcraft
 * Copyright (c) 2021
 */

namespace App\Repositories;


class UserRepository
{
    /**
     * Get user my progress links
     *
     * @param $active
     * @return array[]
     */
    public function getProgressNavigatorLinks($active)
    {
        return [
            [
                'key' => 'my_progress',
                'title' => __('Tests in progress'),
                'url' => route('my_progress'),
                'active' => $active == 'my_progress'
            ],
            [
                'key' => 'my_exams',
                'title' => __('My Exam Attempts'),
                'url' => route('my_exams'),
                'active' => $active == 'my_exams'
            ],
            [
                'key' => 'my_quizzes',
                'title' => __('My Quiz Attempts'),
                'url' => route('my_quizzes'),
                'active' => $active == 'my_quizzes'
            ],
            [
                'key' => 'my_practice',
                'title' => __('My Practice Sessions'),
                'url' => route('my_practice'),
                'active' => $active == 'my_practice'
            ]
        ];
    }
}
