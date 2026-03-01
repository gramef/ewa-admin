-- EWA Hair Platform - Sample Data Population
-- Uber-for-Hair Service Database

-- Insert hair service categories
INSERT INTO categories (name, description, color, order, featured, parent_id, created_at, updated_at) VALUES
('Braids & Twists', 'Professional braiding services including box braids, cornrows, and protective styles', '#8B4513', 1, 1, NULL, datetime('now'), datetime('now')),
('Natural Hair Care', 'Specialized care for natural afro-textured hair including treatments and styling', '#4A4A4A', 2, 1, NULL, datetime('now'), datetime('now')),
('Locs & Dreadlocks', 'Professional loc maintenance, styling, and installation services', '#2F4F4F', 3, 1, NULL, datetime('now'), datetime('now')),
('Weaves & Extensions', 'Sew-in weaves, quick weaves, and extension installations', '#D2691E', 4, 1, NULL, datetime('now'), datetime('now')),
('Chemical Treatments', 'Relaxers, texturizers, and permanent wave services', '#CD853F', 5, 0, NULL, datetime('now'), datetime('now')),
('Hair Color', 'Professional coloring services including highlights, lowlights, and creative colors', '#FF6347', 6, 1, NULL, datetime('now'), datetime('now')),
('Kids Services', 'Specialized hair services for children with gentle techniques', '#FFB6C1', 7, 1, NULL, datetime('now'), datetime('now')),
('Men''s Grooming', 'Men''s haircuts, beard grooming, and male-specific styling', '#4682B4', 8, 1, NULL, datetime('now'), datetime('now'));

-- Insert sample e-provider types (hair stylist specializations)
INSERT INTO e_provider_types (name, created_at, updated_at) VALUES
('Master Braider', datetime('now'), datetime('now')),
('Natural Hair Specialist', datetime('now'), datetime('now')),
('Loctician', datetime('now'), datetime('now')),
('Weave Specialist', datetime('now'), datetime('now')),
('Color Specialist', datetime('now'), datetime('now')),
('Kids Hair Expert', datetime('now'), datetime('now')),
('Barber-Stylist', datetime('now'), datetime('now')),
('Mobile Stylist', datetime('now'), datetime('now'));

-- Insert sample e-providers (hair stylists)
INSERT INTO e_providers (name, description, phone_number, mobile_number, information, address, availability_range, available, featured, accepted, e_provider_type_id, created_at, updated_at) VALUES
('Braids by Nicole', 'Master braider with 15+ years experience specializing in all braid styles', '555-0101', '555-0101', 'I bring the salon to you! Professional braiding services in the comfort of your home.', '123 Main St, Atlanta, GA 30303', 25, 1, 1, 1, 1, datetime('now'), datetime('now')),
('Natural Beauty Studio', 'Certified natural hair care specialist focusing on healthy hair growth', '555-0102', '555-0102', 'Mobile natural hair care services. I come to you with all professional products.', '456 Oak Ave, Atlanta, GA 30304', 30, 1, 1, 1, 2, datetime('now'), datetime('now')),
('Loc Queen Studio', 'Professional loctician with expertise in all loc types and maintenance', '555-0103', '555-0103', 'Mobile loc services including retwists, styles, and treatments. Serving Atlanta area.', '789 Pine St, Atlanta, GA 30305', 35, 1, 1, 1, 3, datetime('now'), datetime('now')),
('Weave Masters', 'Extension specialist offering sew-ins, quick weaves, and custom units', '555-0104', '555-0104', 'Professional weave installation and maintenance. Mobile service available.', '321 Elm St, Atlanta, GA 30306', 40, 1, 1, 1, 4, datetime('now'), datetime('now')),
('Color Me Beautiful', 'Certified color specialist with advanced training in all color techniques', '555-0105', '555-0105', 'Mobile hair coloring services. Professional color treatments in your home.', '654 Maple Dr, Atlanta, GA 30307', 25, 1, 1, 1, 5, datetime('now'), datetime('now')),
('Kids Hair Paradise', 'Specialized children''s hair stylist with gentle techniques and patience', '555-0106', '555-0106', 'Kids hair services at your convenience. Gentle, patient approach for all ages.', '987 Cedar Ln, Atlanta, GA 30308', 20, 1, 1, 1, 6, datetime('now'), datetime('now'));

-- Insert sample e-services (hair services)
INSERT INTO e_services (name, description, price, discount_price, capacity, duration, featured, e_provider_id, category_id, created_at, updated_at) VALUES
-- Braids & Twists Services
('Box Braids (Medium)', 'Classic box braids with medium thickness, includes wash and deep condition', 180.00, NULL, 1, 240, 1, 1, 1, datetime('now'), datetime('now')),
('Knotless Braids', 'Pain-free knotless braiding technique, natural-looking finish', 220.00, NULL, 1, 300, 1, 1, 1, datetime('now'), datetime('now')),
('Cornrows (Simple)', 'Basic cornrow braiding patterns, great for everyday wear', 65.00, NULL, 1, 90, 1, 1, 1, datetime('now'), datetime('now')),
('Ghana Braids', 'Traditional Ghana braiding style with intricate patterns', 120.00, NULL, 1, 180, 1, 1, 1, datetime('now'), datetime('now')),

-- Natural Hair Care Services
('Wash & Go Styling', 'Natural hair wash, condition, and styling for defined curls', 75.00, NULL, 1, 90, 1, 2, 2, datetime('now'), datetime('now')),
('Twist Out Treatment', 'Natural hair twist out with moisturizing treatment', 85.00, NULL, 1, 120, 1, 2, 2, datetime('now'), datetime('now')),
('Deep Conditioning Treatment', 'Intensive moisturizing treatment for natural hair health', 45.00, NULL, 1, 60, 1, 2, 2, datetime('now'), datetime('now')),
('Silk Press', 'Natural hair straightening with silk press technique', 95.00, NULL, 1, 150, 1, 2, 2, datetime('now'), datetime('now')),

-- Loc Services
('Loc Retwist', 'Professional loc maintenance with retwisting service', 85.00, NULL, 1, 120, 1, 3, 3, datetime('now'), datetime('now')),
('Loc Style', 'Creative loc styling after retwist service', 45.00, NULL, 1, 60, 1, 3, 3, datetime('now'), datetime('now')),
('Loc Deep Clean', 'Thorough cleansing and detox for locs', 65.00, NULL, 1, 90, 1, 3, 3, datetime('now'), datetime('now')),
('Starter Locs', 'Professional loc installation for beginners', 150.00, NULL, 1, 240, 1, 3, 3, datetime('now'), datetime('now')),

-- Weave Services
('Sew-In Weave', 'Professional sew-in weave installation with natural blending', 200.00, NULL, 1, 180, 1, 4, 4, datetime('now'), datetime('now')),
('Quick Weave', 'Fast weave installation technique with protective cap', 150.00, NULL, 1, 120, 1, 4, 4, datetime('now'), datetime('now')),
('Weave Maintenance', 'Weave tightening, washing, and styling maintenance', 85.00, NULL, 1, 90, 1, 4, 4, datetime('now'), datetime('now')),
('Lace Front Install', 'Professional lace front wig installation', 250.00, NULL, 1, 240, 1, 4, 4, datetime('now'), datetime('now')),

-- Color Services
('Single Process Color', 'All-over hair color application', 85.00, NULL, 1, 120, 1, 5, 6, datetime('now'), datetime('now')),
('Highlights', 'Professional highlight application with foils', 120.00, NULL, 1, 180, 1, 5, 6, datetime('now'), datetime('now')),
('Balayage', 'Hand-painted highlighting technique for natural look', 180.00, NULL, 1, 240, 1, 5, 6, datetime('now'), datetime('now')),
('Color Correction', 'Professional color correction for previous color issues', 200.00, NULL, 1, 300, 1, 5, 6, datetime('now'), datetime('now')),

-- Kids Services
('Kids Braids', 'Gentle braiding services for children with age-appropriate styles', 45.00, NULL, 1, 60, 1, 6, 7, datetime('now'), datetime('now')),
('Kids Wash & Style', 'Gentle wash and styling for children''s delicate hair', 35.00, NULL, 1, 45, 1, 6, 7, datetime('now'), datetime('now')),
('Kids Natural Hair Care', 'Specialized natural hair care for kids with gentle products', 55.00, NULL, 1, 75, 1, 6, 7, datetime('now'), datetime('now')),
('Kids First Haircut', 'Special first haircut experience with certificate', 25.00, NULL, 1, 30, 1, 6, 7, datetime('now'), datetime('now'));

-- Insert booking statuses
INSERT INTO booking_statuses (id, status, created_at, updated_at) VALUES
(1, 'Received', datetime('now'), datetime('now')),
(10, 'Accepted', datetime('now'), datetime('now')),
(20, 'On the way', datetime('now'), datetime('now')),
(30, 'Ready', datetime('now'), datetime('now')),
(40, 'In Progress', datetime('now'), datetime('now')),
(50, 'Done', datetime('now'), datetime('now')),
(60, 'Failed', datetime('now'), datetime('now'));

-- Insert payment methods
INSERT INTO payment_methods (name, description, route, order, created_at, updated_at) VALUES
('Cash', 'Pay with cash to the stylist upon arrival', 'cash', 1, datetime('now'), datetime('now')),
('Credit Card', 'Secure payment with credit or debit card', 'stripe', 2, datetime('now'), datetime('now')),
('PayPal', 'Pay securely with your PayPal account', 'paypal', 3, datetime('now'), datetime('now')),
('Venmo', 'Quick payment with Venmo mobile app', 'venmo', 4, datetime('now'), datetime('now')),
('Zelle', 'Instant bank transfer with Zelle', 'zelle', 5, datetime('now'), datetime('now'));

-- Insert sample users (customers)
INSERT INTO users (name, email, phone_number, email_verified_at, password, api_token, device_token, created_at, updated_at) VALUES
('Sarah Johnson', 'sarah@example.com', '555-1001', datetime('now'), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer_token_1', 'device_token_1', datetime('now'), datetime('now')),
('Maria Rodriguez', 'maria@example.com', '555-1002', datetime('now'), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer_token_2', 'device_token_2', datetime('now'), datetime('now')),
('Jennifer Smith', 'jennifer@example.com', '555-1003', datetime('now'), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer_token_3', 'device_token_3', datetime('now'), datetime('now')),
('Ashley Davis', 'ashley@example.com', '555-1004', datetime('now'), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer_token_4', 'device_token_4', datetime('now'), datetime('now')),
('Brittany Wilson', 'brittany@example.com', '555-1005', datetime('now'), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer_token_5', 'device_token_5', datetime('now'), datetime('now'));

-- Insert sample bookings
INSERT INTO bookings (user_id, e_service_id, e_provider_id, booking_date, booking_time, duration, status_id, payment_method_id, payment_status_id, address_description, phone_number, cancel_reason, created_at, updated_at) VALUES
(1, 1, 1, date('now', '+2 days'), '10:00', 240, 1, 1, 1, '123 Customer St, Atlanta, GA 30301', '555-1001', NULL, datetime('now'), datetime('now')),
(2, 6, 2, date('now', '+3 days'), '14:00', 90, 1, 2, 1, '456 Client Ave, Atlanta, GA 30302', '555-1002', NULL, datetime('now'), datetime('now')),
(3, 9, 3, date('now', '+1 day'), '16:00', 120, 1, 1, 1, '789 Style Ln, Atlanta, GA 30303', '555-1003', NULL, datetime('now'), datetime('now')),
(4, 13, 4, date('now', '+4 days'), '11:00', 180, 1, 3, 1, '321 Beauty Dr, Atlanta, GA 30304', '555-1004', NULL, datetime('now'), datetime('now')),
(5, 17, 5, date('now', '+2 days'), '13:00', 120, 1, 2, 1, '654 Glamour Ct, Atlanta, GA 30305', '555-1005', NULL, datetime('now'), datetime('now'));