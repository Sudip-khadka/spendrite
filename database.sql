
CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `expense_head` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;Q

CREATE TABLE `incomes` (
  `id` int(11) NOT NULL,
  `source` varchar(50) NOT NULL,
  `amount` int(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `picture` varchar(50) NOT NULL,
  `verification_code` varchar(50) NOT NULL,
  `verification_status` int(2) NOT NULL DEFAULT 0,
  `user_status` int(2) NOT NULL DEFAULT 0,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
