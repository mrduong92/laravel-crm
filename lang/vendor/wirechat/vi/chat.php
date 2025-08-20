<?php

return [

    /**-------------------------
     * Chat
     *------------------------*/
    'labels' => [

        'you_replied_to_yourself' => 'Bạn đã trả lời chính mình',
        'participant_replied_to_you' => ':sender đã trả lời bạn',
        'participant_replied_to_themself' => ':sender đã trả lời chính họ',
        'participant_replied_other_participant' => ':sender đã trả lời :receiver',
        'you' => 'Bạn',
        'user' => 'Người dùng',
        'replying_to' => 'Đang trả lời :participant',
        'replying_to_yourself' => 'Đang trả lời chính mình',
        'attachment' => 'Tệp đính kèm',
    ],

    'inputs' => [
        'message' => [
            'label' => 'Tin nhắn',
            'placeholder' => 'Nhập tin nhắn',
        ],
        'media' => [
            'label' => 'Phương tiện',
            'placeholder' => 'Phương tiện',
        ],
        'files' => [
            'label' => 'Tệp',
            'placeholder' => 'Tệp',
        ],
    ],

    'message_groups' => [
        'today' => 'Hôm nay',
        'yesterday' => 'Hôm qua',

    ],

    'actions' => [
        'open_group_info' => [
            'label' => 'Thông tin nhóm',
        ],
        'open_chat_info' => [
            'label' => 'Thông tin trò chuyện',
        ],
        'close_chat' => [
            'label' => 'Đóng trò chuyện',
        ],
        'clear_chat' => [
            'label' => 'Xóa lịch sử trò chuyện',
            'confirmation_message' => 'Bạn có chắc chắn muốn xóa lịch sử trò chuyện của mình không? Điều này chỉ xóa trò chuyện của bạn và sẽ không ảnh hưởng đến những người tham gia khác.',
        ],
        'delete_chat' => [
            'label' => 'Xóa trò chuyện',
            'confirmation_message' => 'Bạn có chắc chắn muốn xóa cuộc trò chuyện này không? Điều này chỉ xóa cuộc trò chuyện ở phía bạn và sẽ không xóa đối với những người tham gia khác.',
        ],

        'view_suggestion' => [
            'label' => 'Gợi ý trả lời',
        ],

        'delete_for_everyone' => [
            'label' => 'Xóa cho tất cả mọi người',
            'confirmation_message' => 'Bạn có chắc chắn không?',
        ],
        'delete_for_me' => [
            'label' => 'Xóa cho tôi',
            'confirmation_message' => 'Bạn có chắc chắn không?',
        ],
        'reply' => [
            'label' => 'Trả lời',
        ],

        'exit_group' => [
            'label' => 'Rời nhóm',
            'confirmation_message' => 'Bạn có chắc chắn muốn rời nhóm này không?',
        ],
        'upload_file' => [
            'label' => 'Tệp',
        ],
        'upload_media' => [
            'label' => 'Ảnh & Video',
        ],
    ],

    'messages' => [

        'cannot_exit_self_or_private_conversation' => 'Không thể thoát khỏi cuộc trò chuyện cá nhân hoặc riêng tư',
        'owner_cannot_exit_conversation' => 'Chủ sở hữu không thể thoát khỏi cuộc trò chuyện',
        'rate_limit' => 'Quá nhiều lần thử! Vui lòng chậm lại',
        'conversation_not_found' => 'Không tìm thấy cuộc trò chuyện.',
        'conversation_id_required' => 'Yêu cầu mã cuộc trò chuyện',
        'invalid_conversation_input' => 'Dữ liệu cuộc trò chuyện không hợp lệ.',
    ],

    /**-------------------------
     * Info Component
     *------------------------*/

    'info' => [
        'heading' => [
            'label' => 'Thông tin trò chuyện',
        ],
        'actions' => [
            'delete_chat' => [
                'label' => 'Xóa trò chuyện',
                'confirmation_message' => 'Bạn có chắc chắn muốn xóa cuộc trò chuyện này không? Điều này chỉ xóa cuộc trò chuyện ở phía bạn và sẽ không xóa đối với những người tham gia khác.',
            ],
        ],
        'messages' => [
            'invalid_conversation_type_error' => 'Chỉ cho phép cuộc trò chuyện cá nhân và riêng tư',
        ],

    ],

    /**-------------------------
     * Group Folder
     *------------------------*/

    'group' => [

        // Group info component
        'info' => [
            'heading' => [
                'label' => 'Thông tin nhóm',
            ],
            'labels' => [
                'members' => 'Thành viên',
                'add_description' => 'Thêm mô tả nhóm',
            ],
            'inputs' => [
                'name' => [
                    'label' => 'Tên nhóm',
                    'placeholder' => 'Nhập tên',
                ],
                'description' => [
                    'label' => 'Mô tả',
                    'placeholder' => 'Không bắt buộc',
                ],
                'photo' => [
                    'label' => 'Ảnh',
                ],
            ],
            'actions' => [
                'delete_group' => [
                    'label' => 'Xóa nhóm',
                    'confirmation_message' => 'Bạn có chắc chắn muốn xóa nhóm này không?',
                    'helper_text' => 'Trước khi xóa nhóm, bạn cần xóa tất cả thành viên khỏi nhóm.',
                ],
                'add_members' => [
                    'label' => 'Thêm thành viên',
                ],
                'group_permissions' => [
                    'label' => 'Quyền nhóm',
                ],
                'exit_group' => [
                    'label' => 'Rời nhóm',
                    'confirmation_message' => 'Bạn có chắc chắn muốn rời nhóm không?',

                ],
            ],
            'messages' => [
                'invalid_conversation_type_error' => 'Chỉ cho phép cuộc trò chuyện nhóm',
            ],
        ],
        // Members component
        'members' => [
            'heading' => [
                'label' => 'Thành viên',
            ],
            'inputs' => [
                'search' => [
                    'label' => 'Tìm kiếm',
                    'placeholder' => 'Tìm kiếm thành viên',
                ],
            ],
            'labels' => [
                'members' => 'Thành viên',
                'owner' => 'Chủ sở hữu',
                'admin' => 'Quản trị viên',
                'no_members_found' => 'Không tìm thấy thành viên nào',
            ],
            'actions' => [
                'send_message_to_yourself' => [
                    'label' => 'Nhắn tin cho chính mình',

                ],
                'send_message_to_member' => [
                    'label' => 'Nhắn tin cho :member',

                ],
                'dismiss_admin' => [
                    'label' => 'Bỏ quyền quản trị viên',
                    'confirmation_message' => 'Bạn có chắc chắn muốn bỏ quyền quản trị viên của :member không?',
                ],
                'make_admin' => [
                    'label' => 'Thêm quyền quản trị viên',
                    'confirmation_message' => 'Bạn có chắc chắn muốn thêm quyền quản trị viên cho :member không?',
                ],
                'remove_from_group' => [
                    'label' => 'Xóa khỏi nhóm',
                    'confirmation_message' => 'Bạn có chắc chắn muốn xóa :member khỏi nhóm này không?',
                ],
                'load_more' => [
                    'label' => 'Tải thêm',
                ],

            ],
            'messages' => [
                'invalid_conversation_type_error' => 'Chỉ cho phép cuộc trò chuyện nhóm',
            ],
        ],
        // add-Members component
        'add_members' => [
            'heading' => [
                'label' => 'Thêm thành viên',
            ],
            'inputs' => [
                'search' => [
                    'label' => 'Tìm kiếm',
                    'placeholder' => 'Tìm kiếm',
                ],
            ],
            'labels' => [

            ],
            'actions' => [
                'save' => [
                    'label' => 'Lưu',

                ],

            ],
            'messages' => [
                'invalid_conversation_type_error' => 'Chỉ cho phép cuộc trò chuyện nhóm',
                'members_limit_error' => 'Thành viên không được vượt quá :count',
                'member_already_exists' => ' Đã được thêm vào nhóm',
            ],
        ],
        // permissions component
        'permisssions' => [
            'heading' => [
                'label' => 'Quyền',
            ],
            'inputs' => [
                'search' => [
                    'label' => 'Tìm kiếm',
                    'placeholder' => 'Tìm kiếm',
                ],
            ],
            'labels' => [
                'members_can' => 'Thành viên có thể',

            ],
            'actions' => [
                'edit_group_information' => [
                    'label' => 'Chỉnh sửa thông tin nhóm',
                    'helper_text' => 'Bao gồm tên, biểu tượng và mô tả',
                ],
                'send_messages' => [
                    'label' => 'Gửi tin nhắn',
                ],
                'add_other_members' => [
                    'label' => 'Thêm thành viên khác',
                ],

            ],
            'messages' => [
            ],
        ],

    ],

];
