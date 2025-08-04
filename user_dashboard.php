<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login_form.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookish - My Dashboard</title>
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap">
    <!-- AOS Animation Library removed to prevent display issues -->
    <!-- Keeping animations in CSS only -->
    <link rel="stylesheet" href="dashboard_fix.css">
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="image/logo.png">
    
    <style>
        /* Core Variables */
        :root {
            /* Colors */
            --primary: #4A90E2;
            --primary-light: #64B5F6;
            --primary-dark: #357ABD;
            --secondary: #E3F2FD;
            --accent: #FF6B6B;
            --text-dark: #2C3E50;
            --text-light: #7F8C8D;
            --bg-main: #f8f9fa;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            
            /* Dark Theme */
            --dark-primary: #60A5FA;
            --dark-secondary: #1E293B;
            --dark-accent: #F472B6;
            --dark-text: #E2E8F0;
            --dark-text-light: #94A3B8;
            --dark-bg-main: #0F172A;
            --dark-bg-card: #1E293B;
            --dark-border-color: #2D3748;
            
            /* Layout */
            --navbar-height: 70px;
            --sidebar-width: 280px;
            
            /* Styling */
            --background: #fff;
            --gradient-primary: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
            --gradient-secondary: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.12);
            --shadow-lg: 0 8px 30px rgba(74, 144, 226, 0.25);
            --border-radius: 12px;
            --border-radius-lg: 20px;
            --border-radius-sm: 8px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-main);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Playfair Display', serif;
        }

        /* Loader Animation */
        .loader-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.7); /* more transparent background */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.3s, visibility 0.3s;
        }

        .loader {
            position: relative;
            width: 120px;
            height: 120px;
        }

        .book-loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80px;
            height: 60px;
            perspective: 1000px;
        }

        .book-page {
            position: absolute;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            transform-origin: left center;
            background: linear-gradient(to right, #f0f0f0, #fff);
            border-radius: 3px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            animation: pageFlip 1.5s infinite ease-in-out;
        }

        .book-page:nth-child(2) {
            animation-delay: 0.25s;
        }

        .book-page:nth-child(3) {
            animation-delay: 0.5s;
        }

        @keyframes pageFlip {
            0%, 100% { transform: rotateY(0deg); }
            50% { transform: rotateY(-180deg); }
        }

        .brand-name {
            position: absolute;
            bottom: -30px;
            font-family: 'Playfair Display', serif;
            color: var(--primary);
            font-size: 1.8rem;
            font-weight: 600;
            opacity: 0;
            animation: fadeInUp 1s forwards 0.5s;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hidden {
            opacity: 0;
            visibility: hidden;
            display: none !important;
            z-index: -1; /* ensure it's below everything */
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--bg-card);
            position: fixed;
            left: 0;
            top: 0;
            padding: 2rem;
            overflow-y: auto;
            box-shadow: var(--shadow-md);
            z-index: 100;
            transition: var(--transition);
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo img {
            width: 40px;
            height: auto;
            filter: drop-shadow(0px 2px 4px rgba(0, 0, 0, 0.1));
        }

        .logo h2 {
            font-size: 1.6rem;
            color: var(--primary-dark);
            margin: 0;
            letter-spacing: 0.5px;
        }

        .sidebar-close {
            display: none;
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 1.5rem;
            cursor: pointer;
            margin-left: auto;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem;
            background: var(--secondary);
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .user-profile:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-sm);
        }

        .user-profile::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to right,
                rgba(255,255,255,0.1) 0%,
                rgba(255,255,255,0.2) 20%,
                rgba(255,255,255,0) 40%
            );
            transform: rotate(30deg);
            animation: shimmer 4s infinite linear;
            z-index: 1;
        }

        @keyframes shimmer {
            from {
                transform: translateX(-100%) rotate(30deg);
            }
            to {
                transform: translateX(100%) rotate(30deg);
            }
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(74, 144, 226, 0.3);
            position: relative;
            z-index: 2;
        }

        .user-avatar i {
            font-size: 1.5rem;
            color: white;
        }

        .user-info {
            position: relative;
            z-index: 2;
        }

        .user-info p {
            font-size: 0.85rem;
            color: var(--text-light);
            margin: 0;
        }

        .user-info h3 {
            font-size: 1.1rem;
            color: var(--text-dark);
            margin: 0;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-section h4 {
            font-size: 0.8rem;
            text-transform: uppercase;
            color: var(--text-light);
            margin-bottom: 1rem;
            font-weight: 600;
            letter-spacing: 1px;
            padding-left: 0.75rem;
        }

        .nav-items {
            list-style-type: none;
            padding: 0;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.85rem 1rem;
            border-radius: var(--border-radius);
            color: var(--text-dark);
            text-decoration: none;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: var(--primary);
            opacity: 0.1;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .nav-link.active {
            color: var(--primary);
            font-weight: 500;
        }

        .nav-link i {
            font-size: 1.2rem;
            min-width: 1.5rem;
            text-align: center;
            z-index: 2;
        }

        .nav-link span {
            z-index: 2;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .logout-btn {
            color: var(--accent) !important;
        }

        .nav-badge {
            margin-left: auto;
            background: var(--accent);
            color: white;
            font-size: 0.7rem;
            padding: 0.15rem 0.5rem;
            border-radius: 10px;
            z-index: 2;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .social-link {
            color: var(--text-light);
            font-size: 1.2rem;
            transition: var(--transition);
        }

        .social-link:hover {
            color: var(--primary);
            transform: translateY(-3px);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem;
            transition: var(--transition);
            position: relative;
        }

        /* Top Navigation */
        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: var(--bg-card);
            padding: 1rem 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .menu-toggle {
            background: none;
            border: none;
            color: var(--text-dark);
            font-size: 1.5rem;
            cursor: pointer;
            display: none;
        }

        .search-bar {
            flex: 1;
            max-width: 500px;
            margin: 0 2rem;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 3rem;
            border-radius: 50px;
            border: none;
            background: var(--secondary);
            color: var(--text-dark);
            font-size: 0.95rem;
            transition: var(--transition);
            outline: none;
        }

        .search-input:focus {
            box-shadow: 0 0 0 2px var(--primary-light);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .action-btn {
            background: none;
            border: none;
            color: var(--text-dark);
            font-size: 1.2rem;
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: var(--transition);
        }

        .action-btn:hover {
            background: var(--secondary);
            color: var(--primary);
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: var(--accent);
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Dashboard Stats Section */
        .dashboard-stats {
            margin-bottom: 2rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }
        
        .stats-card {
            background: var(--bg-card);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            background: var(--primary);
        }
        
        .stats-card:nth-child(1) .stats-icon {
            background: linear-gradient(135deg, #4CAF50, #8BC34A);
        }
        
        .stats-card:nth-child(2) .stats-icon {
            background: linear-gradient(135deg, #4A90E2, #64B5F6);
        }
        
        .stats-card:nth-child(3) .stats-icon {
            background: linear-gradient(135deg, #9C27B0, #BA68C8);
        }
        
        .stats-card:nth-child(4) .stats-icon {
            background: linear-gradient(135deg, #FF5722, #FF9800);
        }
        
        .stats-content {
            flex: 1;
        }
        
        .stats-content h3 {
            font-size: 0.9rem;
            color: var(--text-light);
            margin-bottom: 0.3rem;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
        }
        
        .stats-content h2 {
            font-size: 1.8rem;
            color: var(--text-dark);
            margin-bottom: 0.3rem;
        }
        
        .stats-content p {
            font-size: 0.85rem;
            color: var(--text-light);
        }
        
        /* Hero Banner Section */
        .hero-banner {
            position: relative;
            margin-bottom: 2.5rem;
            border-radius: var(--border-radius-lg);
            overflow: hidden;
        }

        .banner-content {
            background: var(--gradient-primary);
            padding: 2.5rem;
            color: white;
            position: relative;
            min-height: 280px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-lg);
        }
        
        .banner-text {
            flex: 1;
            max-width: 60%;
            padding-right: 2rem;
        }
        
        .banner-image {
            width: 40%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .banner-image img {
            max-width: 100%;
            max-height: 220px;
            object-fit: contain;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.2));
            animation: float 5s infinite ease-in-out;
        }

        .hero-shapes {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .hero-shape {
            position: absolute;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            right: -100px;
            animation: float 8s infinite alternate ease-in-out;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            bottom: -80px;
            right: 100px;
            animation: float 12s infinite alternate-reverse ease-in-out;
        }

        .shape-3 {
            width: 100px;
            height: 100px;
            bottom: 50px;
            right: 300px;
            animation: float 10s infinite alternate ease-in-out;
        }

        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0); }
        }

        .welcome-text {
            position: relative;
            z-index: 2;
            max-width: 600px;
        }

        .welcome-text h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s forwards 0.2s;
        }

        .welcome-text p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 1.5rem;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s forwards 0.4s;
        }

        .welcome-actions {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s forwards 0.6s;
        }

        .hero-btn {
            padding: 0.85rem 1.5rem;
            border-radius: 50px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: white;
            color: var(--primary-dark);
        }

        .btn-secondary {
            background: rgba(255,255,255,0.2);
            color: white;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .hero-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .hero-btn i {
            font-size: 1.1rem;
        }

        .welcome-stats {
            display: flex;
            gap: 3rem;
            margin-top: 2rem;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s forwards 0.8s;
        }

        .stat {
            display: flex;
            flex-direction: column;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Book Categories Section */
        .book-categories {
            margin-bottom: 2.5rem;
        }
        
        .section-title {
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            color: var(--text-dark);
            position: relative;
            padding-left: 1rem;
            display: inline-block;
        }
        
        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--primary);
            border-radius: 2px;
        }
        
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .category-card {
            position: relative;
            overflow: hidden;
            border-radius: var(--border-radius);
            height: 180px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            text-decoration: none;
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }
        
        .category-image {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            transition: transform 0.6s ease;
        }
        
        .category-card:hover .category-image {
            transform: scale(1.05);
        }
        
        .category-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.5rem;
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);
            color: white;
        }
        
        .category-overlay h3 {
            font-size: 1.25rem;
            margin-bottom: 0.25rem;
        }
        
        .category-overlay p {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        /* Book table message */
        .book-table-message {
            background: rgba(255, 193, 7, 0.1);
            border-left: 4px solid #ffc107;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: var(--border-radius-sm);
        }
        
        .book-table-message p {
            margin: 0;
            color: #856404;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .book-table-message a {
            color: #0056b3;
            font-weight: 500;
            text-decoration: none;
        }
        
        .book-table-message a:hover {
            text-decoration: underline;
        }
        
        /* Enhanced Services Section */
        .services-section {
            margin-bottom: 6rem;
            padding: 3rem 0 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .services-section::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(33, 150, 243, 0.08), rgba(33, 150, 243, 0));
            top: -150px;
            left: -150px;
            z-index: 0;
        }
        
        .services-section::after {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(76, 175, 80, 0.08), rgba(76, 175, 80, 0));
            bottom: -100px;
            right: -100px;
            z-index: 0;
        }
        
        .services-header {
            text-align: center;
            margin-bottom: 4rem;
            position: relative;
            z-index: 1;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }
        
        .section-title::before {
            content: '';
            position: absolute;
            width: 30px;
            height: 5px;
            background: var(--primary);
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 3px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            width: 80px;
            height: 5px;
            background: rgba(33, 150, 243, 0.3);
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 3px;
            z-index: -1;
        }
        
        .services-subtitle {
            color: var(--text-light);
            font-size: 1.2rem;
            margin-top: 1.5rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .services-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2.5rem;
            position: relative;
            z-index: 2;
        }
        
        .service-card {
            background: var(--bg-card);
            border-radius: 20px;
            padding: 2.5rem 2rem 2.5rem;
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(0, 0, 0, 0.05);
            z-index: 1;
            backdrop-filter: blur(5px);
        }
        
        .service-card:hover {
            transform: translateY(-15px);
            box-shadow: var(--shadow-lg);
            z-index: 2;
        }
        
        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 0;
            background: linear-gradient(to bottom, rgba(33, 150, 243, 0.05), rgba(33, 150, 243, 0));
            transition: height 0.5s ease;
            z-index: 0;
        }
        
        .service-card:hover::before {
            height: 100%;
        }
        
        .service-icon-wrapper {
            position: relative;
            width: 90px;
            height: 90px;
            margin-bottom: 2rem;
            z-index: 2;
        }
        
        .service-icon {
            width: 90px;
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            border-radius: 50%;
            color: white;
            position: relative;
            z-index: 2;
            transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        .service-card:hover .service-icon {
            transform: rotateY(180deg) scale(1.1);
        }
        
        .buy-icon {
            background: linear-gradient(135deg, #4CAF50, #8BC34A);
            box-shadow: 0 10px 20px rgba(139, 195, 74, 0.3);
        }
        
        .rent-icon {
            background: linear-gradient(135deg, #2196F3, #03A9F4);
            box-shadow: 0 10px 20px rgba(33, 150, 243, 0.3);
        }
        
        .sell-icon {
            background: linear-gradient(135deg, #F44336, #FF9800);
            box-shadow: 0 10px 20px rgba(244, 67, 54, 0.3);
        }
        
        .audio-icon {
            background: linear-gradient(135deg, #9C27B0, #673AB7);
            box-shadow: 0 10px 20px rgba(156, 39, 176, 0.3);
        }
        
        .ebook-icon {
            background: linear-gradient(135deg, #009688, #4CAF50);
            box-shadow: 0 10px 20px rgba(0, 150, 136, 0.3);
        }
        
        .custom-icon {
            background: linear-gradient(135deg, #FF5722, #FF9800);
            box-shadow: 0 10px 20px rgba(255, 87, 34, 0.3);
        }
        
        .service-icon::before {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            background: conic-gradient(
                from 0deg, 
                transparent 0%, 
                transparent 25%,
                rgba(255, 255, 255, 0.8) 25%,
                rgba(255, 255, 255, 0.8) 30%,
                transparent 30%,
                transparent 100%
            );
            opacity: 0;
            transition: opacity 0.4s ease;
            animation: rotate-conic 4s linear infinite;
        }
        
        .service-card:hover .service-icon::before {
            opacity: 1;
        }
        
        .service-icon::after {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            background: transparent;
            border: 2px dashed rgba(255, 255, 255, 0.5);
            opacity: 0;
            transition: all 0.4s ease;
        }
        
        .service-card:hover .service-icon::after {
            opacity: 0.7;
            animation: rotate-reverse 10s linear infinite;
        }
        
        @keyframes rotate-conic {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        @keyframes rotate-reverse {
            from { transform: rotate(0deg); }
            to { transform: rotate(-360deg); }
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.5;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.2;
            }
            100% {
                transform: scale(1);
                opacity: 0.5;
            }
        }
        
        .service-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 2;
        }
        
        .service-title {
            font-size: 1.6rem;
            margin-bottom: 1.2rem;
            color: var(--text-dark);
            position: relative;
            display: inline-block;
            font-weight: 600;
        }
        
        .service-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 45px;
            height: 3px;
            background: var(--primary);
            transition: width 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        
        .service-card:hover .service-title::after {
            width: 100%;
        }
        
        .service-description {
            color: var(--text-light);
            font-size: 1.05rem;
            line-height: 1.7;
            margin-bottom: 1.8rem;
        }
        
        .service-features {
            display: flex;
            flex-direction: column;
            gap: 0.9rem;
            margin-bottom: 2rem;
        }
        
        .service-feature {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            font-size: 1rem;
            transition: transform 0.3s ease;
        }
        
        .service-card:hover .service-feature {
            transform: translateX(5px);
        }
        
        .service-feature i {
            color: var(--primary);
            font-size: 1rem;
            filter: drop-shadow(0 3px 5px rgba(33, 150, 243, 0.3));
        }
        
        .service-button {
            display: inline-flex;
            align-items: center;
            gap: 0.85rem;
            padding: 1rem 1.8rem;
            background: var(--primary);
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.05rem;
            margin-top: auto;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            overflow: hidden;
            align-self: flex-start;
            box-shadow: 0 5px 15px rgba(33, 150, 243, 0.2);
        }
        
        .service-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(33, 150, 243, 0.4);
        }
        
        .service-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.3);
            transition: transform 0.6s ease;
            transform: skewX(-20deg);
        }
        
        .service-card:hover .service-button::before {
            transform: skewX(-20deg) translateX(200%);
        }
        
        .service-button i {
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .service-card:hover .service-button i {
            transform: translateX(6px);
        }
        
        .service-decoration {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 1;
        }
        
        .floating-element {
            position: absolute;
            border-radius: 50%;
            background: var(--primary);
            opacity: 0.07;
            transition: opacity 0.4s ease;
        }
        
        .service-card:hover .floating-element {
            opacity: 0.12;
        }
        
        .floating-element.one {
            width: 140px;
            height: 140px;
            top: -20px;
            right: -30px;
        }
        
        .floating-element.two {
            width: 90px;
            height: 90px;
            bottom: 30px;
            right: 20px;
        }
        
        .floating-element.three {
            width: 70px;
            height: 70px;
            bottom: -20px;
            left: 30px;
        }
        
        /* Animations for floating elements */
        @keyframes float-one {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(8deg); }
            100% { transform: translateY(0) rotate(0deg); }
        }
        
        @keyframes float-two {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(20px) rotate(-8deg); }
            100% { transform: translateY(0) rotate(0deg); }
        }
        
        @keyframes float-three {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(5deg); }
            100% { transform: translateY(0) rotate(0deg); }
        }
        
        /* Feature Cards */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .feature-card {
            background: var(--bg-card);
            border-radius: var(--border-radius);
            padding: 2rem;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            min-height: 220px;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: var(--secondary);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            position: relative;
            transition: var(--transition);
            z-index: 1;
        }

        .feature-card:hover .feature-icon {
            background: var(--primary);
            color: white;
        }

        .feature-icon::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 15px;
            padding: 2px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: var(--transition);
        }

        .feature-card:hover .feature-icon::before {
            opacity: 1;
        }

        .feature-title {
            font-size: 1.25rem;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
        }

        .feature-description {
            color: var(--text-light);
            font-size: 0.95rem;
            line-height: 1.5;
            flex-grow: 1;
        }

        .feature-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary);
            font-weight: 500;
            text-decoration: none;
            font-size: 0.95rem;
            margin-top: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
            padding: 0.5rem 0;
        }

        .feature-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary-light);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .feature-card:hover .feature-link::after {
            transform: scaleX(1);
        }

        .feature-link i {
            font-size: 0.8rem;
            transition: var(--transition);
        }

        .feature-card:hover .feature-link i {
            transform: translateX(4px);
        }

        /* Recent Books Section */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .section-header h2 {
            font-size: 1.75rem;
            color: var(--text-dark);
            position: relative;
            display: inline-block;
        }

        .section-header h2::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary);
        }

        .section-link {
            color: var(--primary);
            font-weight: 500;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
        }

        .section-link:hover {
            color: var(--primary-dark);
        }

        .section-link i {
            font-size: 0.9rem;
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .book-card {
            background: var(--bg-card);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            position: relative;
        }

        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-md);
        }

        .book-cover {
            position: relative;
            height: 260px;
            overflow: hidden;
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .book-card:hover .book-cover img {
            transform: scale(1.05);
        }

        .book-overlay {
            position: absolute;
            inset: 0;
            background: rgba(74, 144, 226, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: var(--transition);
        }

        .book-card:hover .book-overlay {
            opacity: 1;
        }

        .book-actions {
            display: flex;
            gap: 1rem;
        }

        .book-action {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            text-decoration: none;
            transform: translateY(20px);
            opacity: 0;
            transition: var(--transition);
        }

        .book-card:hover .book-action {
            opacity: 1;
            transform: translateY(0);
        }

        .book-action:nth-child(2) {
            transition-delay: 0.05s;
        }

        .book-action:nth-child(3) {
            transition-delay: 0.1s;
        }

        .book-action:hover {
            background: var(--primary-dark);
            color: white;
        }

        .book-info {
            padding: 1.25rem;
        }

        .book-category {
            color: var(--primary);
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: inline-block;
        }

        .book-title {
            font-size: 1.1rem;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .book-author {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .book-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .book-price {
            font-weight: 600;
            color: var(--primary-dark);
        }

        .book-rating {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .book-rating i {
            color: #FFC107;
            font-size: 0.85rem;
        }

        .book-rating span {
            font-size: 0.9rem;
            color: var(--text-light);
        }

        /* Activity Section */
        .activity-section {
            background: var(--bg-card);
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 3rem;
            box-shadow: var(--shadow-sm);
        }

        .activity-list {
            list-style: none;
            padding: 0;
            margin-top: 1.5rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1.25rem 0;
            border-bottom: 1px solid var(--border-color);
            position: relative;
        }

        .activity-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .activity-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .activity-icon.purple {
            background: rgba(149, 117, 205, 0.1);
            color: #9575cd;
        }

        .activity-icon.blue {
            background: rgba(100, 181, 246, 0.1);
            color: #64b5f6;
        }

        .activity-icon.green {
            background: rgba(129, 199, 132, 0.1);
            color: #81c784;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-size: 1rem;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .activity-subtitle {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .activity-time {
            font-size: 0.85rem;
            color: var(--text-light);
        }

        /* Ripple Effects for Buttons */
        .ripple-effect {
            position: relative;
            overflow: hidden;
        }

        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.7);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple {
            to {
                transform: scale(2.5);
                opacity: 0;
            }
        }

        /* Ensure all elements are visible regardless of animations */
        .welcome-text h1,
        .welcome-text p,
        .welcome-actions,
        .welcome-stats {
            opacity: 1 !important;
            transform: none !important;
            animation: none !important;
        }
        
        .feature-card,
        .section-header,
        .books-grid,
        .book-card,
        .activity-section,
        .activity-item {
            opacity: 1 !important;
            transform: none !important;
        }
        
        /* Dark Theme Styles */
        body.dark-mode {
            background: var(--dark-bg-main);
            color: var(--dark-text);
        }

        body.dark-mode .sidebar,
        body.dark-mode .top-nav,
        body.dark-mode .feature-card,
        body.dark-mode .book-card,
        body.dark-mode .activity-section {
            background: var(--dark-bg-card);
            border-color: var(--dark-border-color);
        }

        body.dark-mode .logo h2,
        body.dark-mode .feature-title,
        body.dark-mode .book-title,
        body.dark-mode .activity-title,
        body.dark-mode .section-header h2 {
            color: var(--dark-text);
        }

        body.dark-mode .nav-link,
        body.dark-mode .action-btn,
        body.dark-mode .feature-description,
        body.dark-mode .book-author,
        body.dark-mode .activity-subtitle,
        body.dark-mode .activity-time {
            color: var(--dark-text-light);
        }

        body.dark-mode .user-profile,
        body.dark-mode .search-input {
            background: var(--dark-secondary);
        }

        body.dark-mode .feature-icon {
            background: rgba(96, 165, 250, 0.1);
        }

        body.dark-mode .activity-icon.purple {
            background: rgba(149, 117, 205, 0.2);
        }

        body.dark-mode .activity-icon.blue {
            background: rgba(100, 181, 246, 0.2);
        }

        body.dark-mode .activity-icon.green {
            background: rgba(129, 199, 132, 0.2);
        }

        body.dark-mode .activity-item {
            border-color: var(--dark-border-color);
        }

        body.dark-mode .social-links {
            border-color: var(--dark-border-color);
        }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }
            
            .categories-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: var(--shadow-lg);
                z-index: 1000;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar-close {
                display: block;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .menu-toggle {
                display: block;
            }
            
            .banner-content {
                flex-direction: column;
                padding: 2rem;
            }
            
            .banner-text {
                max-width: 100%;
                padding-right: 0;
                margin-bottom: 2rem;
                text-align: center;
            }
            
            .banner-image {
                width: 80%;
                margin: 0 auto;
            }
            
            .banner-actions {
                justify-content: center;
            }
            
            /* Services section responsive */
            .services-container {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 2rem;
                padding: 0 1rem;
            }
            
            .service-card {
                padding: 2rem 1.8rem;
            }
            
            .section-title {
                font-size: 2.2rem;
            }
            
            .services-subtitle {
                font-size: 1.1rem;
                padding: 0 2rem;
            }
        }

        @media (max-width: 768px) {
            .search-bar {
                display: none;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .banner-actions {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }

            .hero-btn {
                width: 100%;
                text-align: center;
                justify-content: center;
            }
            
            /* Services section responsive */
            .services-section {
                padding: 2rem 0 1rem;
                margin-bottom: 4rem;
            }
            
            .services-header {
                margin-bottom: 2.5rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .section-title::before,
            .section-title::after {
                bottom: -10px;
            }
            
            .services-subtitle {
                font-size: 1rem;
                padding: 0 1rem;
            }
            
            .services-container {
                grid-template-columns: 1fr;
                gap: 2rem;
                max-width: 450px;
                margin-left: auto;
                margin-right: auto;
            }
            
            .service-card {
                padding: 2rem 1.5rem;
            }
            
            .service-icon-wrapper {
                margin-bottom: 1.5rem;
                margin-left: auto;
                margin-right: auto;
            }
            
            .service-content {
                text-align: center;
            }
            
            .service-title {
                display: inline-block;
            }
            
            .service-title::after {
                left: 50%;
                transform: translateX(-50%);
            }
            
            .service-feature {
                justify-content: center;
            }
            
            .service-button {
                align-self: center;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 1rem;
            }
            
            /* Services section responsive */
            .services-section {
                padding: 1.5rem 0 1rem;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
            
            .services-subtitle {
                font-size: 0.95rem;
            }
            
            .service-card {
                padding: 1.8rem 1.2rem;
            }
            
            .service-icon {
                width: 80px;
                height: 80px;
                font-size: 1.8rem;
            }
            
            .service-title {
                font-size: 1.4rem;
            }
            
            .service-description {
                font-size: 1rem;
                margin-bottom: 1.5rem;
            }
            
            .service-features {
                margin-bottom: 1.5rem;
            }
            
            .service-button {
                padding: 0.8rem 1.5rem;
                font-size: 0.95rem;
            }
            
            .banner-text h1 {
                font-size: 1.8rem;
            }
            
            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 1rem;
            }
            
            .book-cover {
                height: 220px;
            }
            
            .book-info {
                padding: 1rem;
            }
            
            .section-title {
                font-size: 1.5rem;
            }
            
            .feature-card {
                padding: 1.5rem;
                min-height: auto;
            }
            
            .categories-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-card {
                padding: 1rem;
            }
        }
    </style>
</head>

<body style="min-height: 100vh; display: flex;">
    <!-- Immediate loader hiding script -->
    <script>
        // Hide loader immediately
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('loaderWrapper').classList.add('hidden');
        });
        
        // Backup method - hide loader immediately without waiting for DOM
        (function() {
            // Try to hide immediately
            var loader = document.getElementById('loaderWrapper');
            if (loader) loader.classList.add('hidden');
            
            // Also add inline style to force hiding
            if (loader) loader.style.display = 'none';
            
            // Fallback - hide after minimal timeout
            setTimeout(function() {
                var loader = document.getElementById('loaderWrapper');
                if (loader) {
                    loader.classList.add('hidden');
                    loader.style.display = 'none';
                }
            }, 100);
        })();
    </script>
    
    <!-- Page Loader (with inline style as backup) -->
    <div class="loader-wrapper hidden" id="loaderWrapper" style="display:none;">
        <div class="loader">
            <div class="book-loader">
                <div class="book-page"></div>
                <div class="book-page"></div>
                <div class="book-page"></div>
            </div>
            <div class="brand-name">Bookish</div>
        </div>
    </div>
    
    <!-- Sidebar Navigation -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <img src="image/logo.png" alt="Bookish Logo">
                <h2>Bookish</h2>
            </div>
            <button class="sidebar-close" id="sidebarClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="user-profile">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="user-info">
                <p>Welcome back,</p>
                <h3><?php echo $_SESSION['username']; ?></h3>
            </div>
        </div>
        
        <div class="nav-section">
            <h4>Main Menu</h4>
            <ul class="nav-items">
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="profile.php" class="nav-link">
                        <i class="fas fa-user"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="cart.php" class="nav-link">
                        <i class="fas fa-shopping-cart"></i>
                        <span>My Cart</span>
                        <span class="nav-badge">3</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="nav-section">
            <h4>Books & Services</h4>
            <ul class="nav-items">
                <li class="nav-item">
                    <a href="buy.php" class="nav-link">
                        <i class="fas fa-book-open"></i>
                        <span>Buy Books</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="rent.php" class="nav-link">
                        <i class="fas fa-sync"></i>
                        <span>Rent Books</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="add_item.php" class="nav-link">
                        <i class="fas fa-upload"></i>
                        <span>Sell Books</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="audio.php" class="nav-link">
                        <i class="fas fa-headphones"></i>
                        <span>Audio Books</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="e-books.php" class="nav-link">
                        <i class="fas fa-tablet-alt"></i>
                        <span>E-Books</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="custom_order.php" class="nav-link">
                        <i class="fas fa-magic"></i>
                        <span>Custom Order</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="nav-section">
            <h4>More</h4>
            <ul class="nav-items">
                <li class="nav-item">
                    <a href="aboutus.html" class="nav-link">
                        <i class="fas fa-info-circle"></i>
                        <span>About Us</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="logoutt.php" class="nav-link logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="social-links">
            <a href="#" class="social-link">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-link">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://www.instagram.com/code._.craftt/" class="social-link">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://www.linkedin.com/in/rajpal-rathore-4293151b6/" class="social-link">
                <i class="fab fa-linkedin-in"></i>
            </a>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="main-content" style="flex: 1; margin-left: var(--sidebar-width); padding: 2rem; overflow-y: auto; position: relative; display: block; visibility: visible;">
        <!-- Top Navigation -->
        <div class="top-nav">
            <button class="menu-toggle ripple-effect" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="search-bar">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search for books, authors, or categories...">
            </div>
            
            <div class="nav-actions">
                <button class="action-btn ripple-effect">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </button>
                <button class="action-btn ripple-effect" id="themeToggle">
                    <i class="fas fa-moon"></i>
                </button>
                <a href="profile.php" class="action-btn ripple-effect">
                    <i class="fas fa-user"></i>
                </a>
            </div>
        </div>
        
        <!-- Hero Dashboard Stats Section -->
        <section class="dashboard-stats">
            <div class="stats-grid">
                <!-- User Activity Stats Card -->
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="stats-content">
                        <h3>Welcome Back</h3>
                        <h2><?php echo $_SESSION['username']; ?></h2>
                        <p>Last login: Today, <?php echo date("h:i A"); ?></p>
                    </div>
                </div>
                
                <!-- Books Stats Card -->
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stats-content">
                        <h3>Books Available</h3>
                        <h2 id="booksCount">1,500+</h2>
                        <p>Browse our collection</p>
                    </div>
                </div>
                
                <!-- Audiobooks Stats Card -->
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-headphones"></i>
                    </div>
                    <div class="stats-content">
                        <h3>Audio Books</h3>
                        <h2>500+</h2>
                        <p>Listen on the go</p>
                    </div>
                </div>
                
                <!-- E-Books Stats Card -->
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-tablet-alt"></i>
                    </div>
                    <div class="stats-content">
                        <h3>E-Books</h3>
                        <h2>1,200+</h2>
                        <p>Read on any device</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Hero Banner Section -->
        <section class="hero-banner">
            <div class="banner-content">
                <div class="banner-text">
                    <h1>Discover Your Next Favorite Book</h1>
                    <p>Explore our vast collection of books, e-books, and audiobooks. Buy, sell, or rent - everything in one place!</p>
                    <div class="banner-actions">
                        <a href="buy.php" class="hero-btn btn-primary ripple-effect">
                            <i class="fas fa-shopping-cart"></i>
                            Shop Books
                        </a>
                        <a href="add_item.php" class="hero-btn btn-secondary ripple-effect">
                            <i class="fas fa-upload"></i>
                            Sell Your Books
                        </a>
                    </div>
                </div>
                <div class="banner-image">
                    <img src="https://img.freepik.com/free-vector/hand-drawn-flat-design-stack-books_23-2149334862.jpg" alt="Book Collection">
                </div>
            </div>
        </section>
        
        <!-- Book Categories Section -->
        <section class="book-categories">
            <h2 class="section-title">Explore Book Categories</h2>
            <div class="categories-grid">
                <a href="buy.php?category=fiction" class="category-card">
                    <div class="category-image" style="background-image: url('https://img.freepik.com/free-photo/book-composition-with-open-book_23-2147690555.jpg');">
                        <div class="category-overlay">
                            <h3>Fiction</h3>
                            <p>300+ Books</p>
                        </div>
                    </div>
                </a>
                <a href="buy.php?category=non-fiction" class="category-card">
                    <div class="category-image" style="background-image: url('https://img.freepik.com/free-photo/front-view-stacked-books-graduation-cap-education-day_23-2149241011.jpg');">
                        <div class="category-overlay">
                            <h3>Non-Fiction</h3>
                            <p>250+ Books</p>
                        </div>
                    </div>
                </a>
                <a href="buy.php?category=textbooks" class="category-card">
                    <div class="category-image" style="background-image: url('https://img.freepik.com/free-photo/book-with-green-board-background_1150-3836.jpg');">
                        <div class="category-overlay">
                            <h3>Textbooks</h3>
                            <p>500+ Books</p>
                        </div>
                    </div>
                </a>
                <a href="buy.php?category=children" class="category-card">
                    <div class="category-image" style="background-image: url('https://img.freepik.com/free-photo/cute-fluffy-toy-sits-stack-books_1340-37561.jpg');">
                        <div class="category-overlay">
                            <h3>Children's Books</h3>
                            <p>200+ Books</p>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <!-- Redesigned Services Section -->
        <section class="services-section">
            <div class="services-header">
                <h2 class="section-title">Our Services</h2>
                <p class="services-subtitle">Discover the perfect way to enjoy your next great read</p>
            </div>
            
            <div class="services-container">
                <!-- Service Card 1 - Buy Books -->
                <div class="service-card" onmouseover="startAnimation(this)" onmouseout="stopAnimation(this)">
                    <div class="service-icon-wrapper">
                        <div class="service-icon buy-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">Buy Books</h3>
                        <p class="service-description">Discover our vast collection of new and pre-loved books at competitive prices. From bestsellers to rare finds, there's something for every reader.</p>
                        <div class="service-features">
                            <div class="service-feature">
                                <i class="fas fa-check-circle"></i>
                                <span>New arrivals weekly</span>
                            </div>
                            <div class="service-feature">
                                <i class="fas fa-check-circle"></i>
                                <span>Free shipping over ₹499</span>
                            </div>
                        </div>
                        <a href="buy.php" class="service-button">
                            <span>Browse Collection</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="service-decoration">
                        <div class="floating-element one"></div>
                        <div class="floating-element two"></div>
                        <div class="floating-element three"></div>
                    </div>
                </div>
                
                <!-- Service Card 2 - Rent Books -->
                <div class="service-card" onmouseover="startAnimation(this)" onmouseout="stopAnimation(this)">
                    <div class="service-icon-wrapper">
                        <div class="service-icon rent-icon">
                            <i class="fas fa-sync"></i>
                        </div>
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">Rent Books</h3>
                        <p class="service-description">Save money by renting books instead of buying. Perfect for textbooks, reference materials, and short-term reads.</p>
                        <div class="service-features">
                            <div class="service-feature">
                                <i class="fas fa-check-circle"></i>
                                <span>Flexible rental periods</span>
                            </div>
                            <div class="service-feature">
                                <i class="fas fa-check-circle"></i>
                                <span>Up to 70% savings</span>
                            </div>
                        </div>
                        <a href="rent.php" class="service-button">
                            <span>View Rental Options</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="service-decoration">
                        <div class="floating-element one"></div>
                        <div class="floating-element two"></div>
                        <div class="floating-element three"></div>
                    </div>
                </div>
                
                <!-- Service Card 3 - Sell Books -->
                <div class="service-card" onmouseover="startAnimation(this)" onmouseout="stopAnimation(this)">
                    <div class="service-icon-wrapper">
                        <div class="service-icon sell-icon">
                            <i class="fas fa-upload"></i>
                        </div>
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">Sell Books</h3>
                        <p class="service-description">List your used books for sale. Set your price and reach thousands of potential buyers in our marketplace.</p>
                        <div class="service-features">
                            <div class="service-feature">
                                <i class="fas fa-check-circle"></i>
                                <span>No listing fees</span>
                            </div>
                            <div class="service-feature">
                                <i class="fas fa-check-circle"></i>
                                <span>Quick payment processing</span>
                            </div>
                        </div>
                        <a href="add_item.php" class="service-button">
                            <span>Start Selling</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="service-decoration">
                        <div class="floating-element one"></div>
                        <div class="floating-element two"></div>
                        <div class="floating-element three"></div>
                    </div>
                </div>
                
                <!-- Service Card 4 - Audio Books -->
                <div class="service-card" onmouseover="startAnimation(this)" onmouseout="stopAnimation(this)">
                    <div class="service-icon-wrapper">
                        <div class="service-icon audio-icon">
                            <i class="fas fa-headphones"></i>
                        </div>
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">Audio Books</h3>
                        <p class="service-description">Listen to your favorite books on the go. Perfect for commutes, workouts, and multitasking.</p>
                        <div class="service-features">
                            <div class="service-feature">
                                <i class="fas fa-check-circle"></i>
                                <span>Professional narration</span>
                            </div>
                            <div class="service-feature">
                                <i class="fas fa-check-circle"></i>
                                <span>Stream or download</span>
                            </div>
                        </div>
                        <a href="audio.php" class="service-button">
                            <span>Explore Audio</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="service-decoration">
                        <div class="floating-element one"></div>
                        <div class="floating-element two"></div>
                        <div class="floating-element three"></div>
                    </div>
                </div>
                
                <!-- Service Card 5 - E-Books -->
                <div class="service-card" onmouseover="startAnimation(this)" onmouseout="stopAnimation(this)">
                    <div class="service-icon-wrapper">
                        <div class="service-icon ebook-icon">
                            <i class="fas fa-tablet-alt"></i>
                        </div>
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">E-Books</h3>
                        <p class="service-description">Access your favorite books instantly on any device. Read anywhere, anytime with our digital collection.</p>
                        <div class="service-features">
                            <div class="service-feature">
                                <i class="fas fa-check-circle"></i>
                                <span>Instant delivery</span>
                            </div>
                            <div class="service-feature">
                                <i class="fas fa-check-circle"></i>
                                <span>Multiple device support</span>
                            </div>
                        </div>
                        <a href="e-books.php" class="service-button">
                            <span>View E-Books</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="service-decoration">
                        <div class="floating-element one"></div>
                        <div class="floating-element two"></div>
                        <div class="floating-element three"></div>
                    </div>
                </div>
                
                <!-- Service Card 6 - Custom Orders -->
                <div class="service-card" onmouseover="startAnimation(this)" onmouseout="stopAnimation(this)">
                    <div class="service-icon-wrapper">
                        <div class="service-icon custom-icon">
                            <i class="fas fa-magic"></i>
                        </div>
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">Custom Orders</h3>
                        <p class="service-description">Can't find what you're looking for? Request a custom book order tailored to your specific needs.</p>
                        <div class="service-features">
                            <div class="service-feature">
                                <i class="fas fa-check-circle"></i>
                                <span>Personalized service</span>
                            </div>
                            <div class="service-feature">
                                <i class="fas fa-check-circle"></i>
                                <span>Rare book sourcing</span>
                            </div>
                        </div>
                        <a href="custom_order.php" class="service-button">
                            <span>Order Custom Books</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="service-decoration">
                        <div class="floating-element one"></div>
                        <div class="floating-element two"></div>
                        <div class="floating-element three"></div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Recent Books Section -->
        <section class="recent-books">
            <div class="section-header">
                <h2>Recently Added Books</h2>
                <a href="buy.php" class="section-link">
                    View All
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="books-grid">
                <!-- Book 1 -->
                <div class="book-card">
                    <div class="book-cover">
                        <img src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1668782119i/40097951.jpg" alt="The Silent Patient">
                        <div class="book-overlay">
                            <div class="book-actions">
                                <a href="buy.php?id=1" class="book-action">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                                <a href="#" class="book-action">
                                    <i class="far fa-heart"></i>
                                </a>
                                <a href="#" class="book-action">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="book-info">
                        <span class="book-category">Thriller</span>
                        <h3 class="book-title">The Silent Patient</h3>
                        <p class="book-author">by Alex Michaelides</p>
                        <div class="book-meta">
                            <span class="book-price">₹499.99</span>
                            <div class="book-rating">
                                <i class="fas fa-star"></i>
                                <span>4.5</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Book 2 -->
                <div class="book-card">
                    <div class="book-cover">
                        <img src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1655988385i/40121378.jpg" alt="Atomic Habits">
                        <div class="book-overlay">
                            <div class="book-actions">
                                <a href="buy.php?id=2" class="book-action">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                                <a href="#" class="book-action">
                                    <i class="far fa-heart"></i>
                                </a>
                                <a href="#" class="book-action">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="book-info">
                        <span class="book-category">Self-Help</span>
                        <h3 class="book-title">Atomic Habits</h3>
                        <p class="book-author">by James Clear</p>
                        <div class="book-meta">
                            <span class="book-price">₹399.99</span>
                            <div class="book-rating">
                                <i class="fas fa-star"></i>
                                <span>5.0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Book 3 -->
                <div class="book-card">
                    <div class="book-cover">
                        <img src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1602190253i/52578297.jpg" alt="The Midnight Library">
                        <div class="book-overlay">
                            <div class="book-actions">
                                <a href="buy.php?id=3" class="book-action">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                                <a href="#" class="book-action">
                                    <i class="far fa-heart"></i>
                                </a>
                                <a href="#" class="book-action">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="book-info">
                        <span class="book-category">Fiction</span>
                        <h3 class="book-title">The Midnight Library</h3>
                        <p class="book-author">by Matt Haig</p>
                        <div class="book-meta">
                            <span class="book-price">₹449.99</span>
                            <div class="book-rating">
                                <i class="fas fa-star"></i>
                                <span>4.0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Book 4 -->
                <div class="book-card">
                    <div class="book-cover">
                        <img src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1666902139i/62023480.jpg" alt="The Fourth Wing">
                        <div class="book-overlay">
                            <div class="book-actions">
                                <a href="buy.php?id=4" class="book-action">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                                <a href="#" class="book-action">
                                    <i class="far fa-heart"></i>
                                </a>
                                <a href="#" class="book-action">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="book-info">
                        <span class="book-category">Fantasy</span>
                        <h3 class="book-title">The Fourth Wing</h3>
                        <p class="book-author">by Rebecca Yarros</p>
                        <div class="book-meta">
                            <span class="book-price">₹549.99</span>
                            <div class="book-rating">
                                <i class="fas fa-star"></i>
                                <span>4.7</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Book 5 -->
                <div class="book-card">
                    <div class="book-cover">
                        <img src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1620324329i/16096824.jpg" alt="A Court of Thorns and Roses">
                        <div class="book-overlay">
                            <div class="book-actions">
                                <a href="buy.php?id=5" class="book-action">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                                <a href="#" class="book-action">
                                    <i class="far fa-heart"></i>
                                </a>
                                <a href="#" class="book-action">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="book-info">
                        <span class="book-category">Fantasy</span>
                        <h3 class="book-title">A Court of Thorns and Roses</h3>
                        <p class="book-author">by Sarah J. Maas</p>
                        <div class="book-meta">
                            <span class="book-price">₹499.99</span>
                            <div class="book-rating">
                                <i class="fas fa-star"></i>
                                <span>4.2</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Recent Activity Section removed as requested -->
    </main>
    
    <!-- JavaScript -->
    <script src="service-animations.js"></script>
    <script>
        // Initialize AOS animations
        document.addEventListener('DOMContentLoaded', function() {
            // IMPORTANT: Make sure everything is visible regardless of AOS
            document.querySelectorAll('[data-aos]').forEach(el => {
                // Remove AOS attributes to ensure elements are visible
                el.removeAttribute('data-aos');
                el.removeAttribute('data-aos-delay');
                el.style.opacity = '1';
                el.style.transform = 'none';
            });
            
            // Force remove the loader completely from DOM
            try {
                const loader = document.getElementById('loaderWrapper');
                if (loader) {
                    loader.classList.add('hidden');
                    loader.style.display = 'none';
                    loader.style.zIndex = '-10';
                    loader.style.opacity = '0';
                    // After a second, remove it from DOM completely
                    setTimeout(() => {
                        if (loader && loader.parentNode) {
                            loader.parentNode.removeChild(loader);
                        }
                    }, 100);
                }
            } catch(e) {
                console.error("Error handling loader:", e);
            }
            
            // Sidebar Toggle for Mobile
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarClose = document.getElementById('sidebarClose');
            
            if (menuToggle && sidebar && sidebarClose) {
                menuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
                
                sidebarClose.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                });
                
                // Close sidebar when clicking outside
                document.addEventListener('click', function(event) {
                    if (!sidebar.contains(event.target) && !menuToggle.contains(event.target) && sidebar.classList.contains('active')) {
                        sidebar.classList.remove('active');
                    }
                });
            }
            
            // Dark Mode Toggle
            const themeToggle = document.getElementById('themeToggle');
            const body = document.body;
            
            if (themeToggle) {
                const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
                
                // Check for saved theme preference or system preference
                if (localStorage.getItem('darkMode') === 'true' || 
                    (localStorage.getItem('darkMode') === null && prefersDarkScheme.matches)) {
                    body.classList.add('dark-mode');
                    themeToggle.querySelector('i').classList.replace('fa-moon', 'fa-sun');
                }
                
                themeToggle.addEventListener('click', function() {
                    body.classList.toggle('dark-mode');
                    const isDark = body.classList.contains('dark-mode');
                    localStorage.setItem('darkMode', isDark);
                    
                    // Toggle icon
                    const icon = themeToggle.querySelector('i');
                    if (isDark) {
                        icon.classList.replace('fa-moon', 'fa-sun');
                    } else {
                        icon.classList.replace('fa-sun', 'fa-moon');
                    }
                });
            }
            
            // Ripple Effect for Buttons
            const rippleButtons = document.querySelectorAll('.ripple-effect');
            
            rippleButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    ripple.classList.add('ripple');
                    this.appendChild(ripple);
                    
                    const rect = button.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    ripple.style.left = `${x}px`;
                    ripple.style.top = `${y}px`;
                    
                    const width = Math.max(rect.width, rect.height);
                    ripple.style.width = ripple.style.height = `${width * 2}px`;
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
            
            // Animate stats numbers with counter
            function animateCounter(element, targetValue) {
                if (!element) return;
                
                const duration = 2000; // 2 seconds
                const frameRate = 30; // frames per second
                const totalFrames = duration / 1000 * frameRate;
                const initialValue = 0;
                const valueIncrement = (targetValue - initialValue) / totalFrames;
                
                let currentFrame = 0;
                let currentValue = initialValue;
                
                const counter = setInterval(() => {
                    currentFrame++;
                    currentValue += valueIncrement;
                    
                    if (currentFrame === totalFrames) {
                        clearInterval(counter);
                        element.textContent = targetValue;
                    } else {
                        element.textContent = Math.floor(currentValue);
                    }
                }, 1000 / frameRate);
            }
            
            // Immediately animate stats without using observer
            const booksCount = document.getElementById('booksCount');
            const usersCount = document.getElementById('usersCount');
            const genresCount = document.getElementById('genresCount');
            
            // Start the animation with a slight delay
            setTimeout(() => {
                if (booksCount) animateCounter(booksCount, 1500);
                if (usersCount) animateCounter(usersCount, 5000);
                if (genresCount) animateCounter(genresCount, 50);
            }, 500);
        });
    </script>
</body>
</html>
