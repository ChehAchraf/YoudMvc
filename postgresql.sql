-- Create Database
DROP DATABASE IF EXISTS youmvc;
CREATE DATABASE youmvc;

-- Connect to database
\c youmvc;

-- Create ENUMs
CREATE TYPE user_role AS ENUM ('admin', 'teacher', 'student');
CREATE TYPE user_status AS ENUM ('pending', 'approved', 'blocked');
CREATE TYPE content_type AS ENUM ('video', 'document', 'mixed');
CREATE TYPE course_level AS ENUM ('beginner', 'intermediate', 'advanced');
CREATE TYPE course_status AS ENUM ('draft', 'published', 'archived');

-- Create Categories Table
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    parent_id INTEGER REFERENCES categories(id) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Users Table
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role user_role DEFAULT 'student',
    status user_status DEFAULT 'pending',
    profile_image VARCHAR(255),
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Courses Table
CREATE TABLE courses (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    category_id INTEGER REFERENCES categories(id) ON DELETE SET NULL,
    instructor_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    thumbnail VARCHAR(255),
    content_type content_type NOT NULL,
    content_url VARCHAR(255),
    file_path VARCHAR(255),
    duration INTEGER,
    price DECIMAL(10,2) DEFAULT 0.00,
    level course_level DEFAULT 'beginner',
    status course_status DEFAULT 'draft',
    is_free BOOLEAN DEFAULT FALSE,
    published_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Course Progress Table
CREATE TABLE course_progress (
    id SERIAL PRIMARY KEY,
    enrollment_id INTEGER NOT NULL,
    progress INTEGER DEFAULT 0,
    last_accessed TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Course Reviews Table
CREATE TABLE course_reviews (
    id SERIAL PRIMARY KEY,
    course_id INTEGER REFERENCES courses(id) ON DELETE CASCADE,
    user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    rating INTEGER CHECK (rating >= 1 AND rating <= 5),
    review TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Tags Table
CREATE TABLE tags (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    slug VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Course Tags Table
CREATE TABLE course_tags (
    course_id INTEGER REFERENCES courses(id) ON DELETE CASCADE,
    tag_id INTEGER REFERENCES tags(id) ON DELETE CASCADE,
    PRIMARY KEY (course_id, tag_id)
);

-- Create Enrollments Table
CREATE TABLE enrollments (
    id SERIAL PRIMARY KEY,
    course_id INTEGER REFERENCES courses(id) ON DELETE CASCADE,
    user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP,
    progress INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create function for updating timestamps
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ language 'plpgsql';

-- Create triggers for updated_at columns
CREATE TRIGGER update_users_modtime
    BEFORE UPDATE ON users
    FOR EACH ROW
    EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_courses_modtime
    BEFORE UPDATE ON courses
    FOR EACH ROW
    EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_course_reviews_modtime
    BEFORE UPDATE ON course_reviews
    FOR EACH ROW
    EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_enrollments_modtime
    BEFORE UPDATE ON enrollments
    FOR EACH ROW
    EXECUTE FUNCTION update_updated_at_column();

-- Insert initial data
INSERT INTO categories (name, slug, description) VALUES
('Web Development', 'web-development', 'Learn web development technologies'),
('Data Science', 'data-science', 'Master data science and analytics'),
('Mobile Development', 'mobile-development', 'Build mobile applications'),
('Ethical Hacking', 'ethical-hacking', 'The best Place where u can start learning ethical hacking'),
('Ana zaml', 'ana-zaml', '3afak abid aji n7wik'),
('DevOps', 'devops', 'A place where u can grow ur knwoledge'),
('Ana zamlzefzef', 'ana-zamlzefzef', '3afak abid aji n7wikzaedfef');

-- Insert users
INSERT INTO users (first_name, last_name, email, password, role, status) VALUES
('Admin', 'User', 'admin@example.com', '$2y$10$8zUwhBi/HihL9.TpG1OyEOY.PtX6FBUxVPMGrV9FYCTZgX7ZxGjNi', 'admin', 'approved'),
('houssam', 'lambaraa', 'houssam@gmail.com', '$2y$10$To9GVZh5niPzJA36qnlKr.1QtuO0k0uWCYzhVPv0VuWck0EMMvZ1a', 'teacher', 'approved'),
('wissam', 'douskary', 'wissam@gmail.com', '$2y$10$cbTLoIw874etWlRzOpJnRevnVKyU6RlwLuV3T2bc3xaASFywFK1oa', 'student', 'approved'),
('abdelmalek', 'labid', 'abdo@gmail.com', '$2y$10$Jqi38HcsPIroa9CCfEy7runcDtbNFKRsKAXafbKyroD/iPU9QM9cC', 'teacher', 'approved'),
('hatim', 'belghiti', 'hatim@gmail.com', '$2y$10$xWBDkNFuloRDGXxTyF5sEeqBHk2rPFL83EJAt1xTLnibwwF6HeM5i', 'teacher', 'approved');

-- Insert the instructor (user_id = 10) first
INSERT INTO users (id, first_name, last_name, email, password, role, status) VALUES 
(10, 'houssam', 'lambaraa', 'houssam@gmail.com', '$2y$10$To9GVZh5niPzJA36qnlKr.1QtuO0k0uWCYzhVPv0VuWck0EMMvZ1a', 'teacher', 'approved');

-- Insert courses that reference instructor_id = 10
INSERT INTO courses (title, slug, description, category_id, instructor_id, thumbnail, content_type, content_url, file_path, price, level, status) VALUES
('Introduction into syber security', '', 'Master the essentials of cybersecurity with this comprehensive course. Learn how to protect systems, networks, and data from cyber threats, understand key security protocols, and develop strategies for safeguarding digital assets in an ever-evolving landscape', 4, 10, 'thumbnails/67a4933b83751_logo (1).webp', 'video', NULL, NULL, 100.00, 'beginner', 'published'),
('Vue.js [ Full course For beginners ]', 'vue-js-full-course-for-beginners-', 'Vue.js is a progressive JavaScript framework used for building modern web applications. It focuses on the view layer, offering a flexible and reactive approach to building user interfaces. Vue provides an easy-to-learn structure with features like component-based development, two-way data binding, and a powerful ecosystem for routing, state management, and more. Perfect for creating interactive and dynamic front-end applications, Vue.js simplifies complex tasks and improves development efficiency.', 1, 10, 'thumbnails/67a48b6908444_0_zeeMDIHPVzjsyeuY.jpg', 'video', 'https://www.youtube.com/watch?v=KgcKB7ZrPvw&pp=ygUFdnVlanM%3D', '', 150.00, 'beginner', 'published');

-- Create indexes
CREATE INDEX idx_course_instructor ON courses(instructor_id);
CREATE INDEX idx_course_category ON courses(category_id);
CREATE INDEX idx_enrollment_user_course ON enrollments(user_id, course_id);
CREATE INDEX idx_review_course ON course_reviews(course_id);
CREATE INDEX idx_user_email ON users(email);
CREATE INDEX idx_category_slug ON categories(slug);
CREATE INDEX idx_course_slug ON courses(slug);
CREATE INDEX idx_tag_slug ON tags(slug);
