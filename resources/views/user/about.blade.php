<x-layout title="BookEase • About Us" bodyClass="user-page">
    <x-user-header />

    <main class="user-main">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 20px;">
            <!-- Hero Section -->
            <section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 80px 50px; text-align: center; border-radius: 16px; margin: 30px 0 60px; box-shadow: 0 8px 32px rgba(0,0,0,.15); position: relative; overflow: hidden;">
                <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: relative; z-index: 1;">
                    <h1 style="font-size: 56px; font-weight: 800; margin: 0 0 20px 0; text-shadow: 0 2px 10px rgba(0,0,0,.2);">
                        <i class="fa-solid fa-book"></i> About BookEase
                    </h1>
                    <p style="font-size: 24px; margin: 0; opacity: 0.95; font-weight: 500; max-width: 800px; margin: 0 auto;">
                        Your trusted partner in making books accessible to everyone
                    </p>
                </div>
            </section>

            <!-- Mission Section -->
            <section style="background: #fff; padding: 50px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.1); margin-bottom: 50px;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 50px; align-items: center;">
                    <div>
                        <h2 style="color: #2e7d32; margin-bottom: 25px; font-size: 36px; display: flex; align-items: center; gap: 15px;">
                            <i class="fa-solid fa-bullseye"></i> Our Mission
                        </h2>
                        <p style="color: #666; line-height: 1.9; font-size: 18px; margin: 0;">
                            BookEase is dedicated to making reading accessible to everyone. We provide a seamless platform for book borrowing, 
                            allowing users to discover, borrow, and enjoy books without the hassle of traditional library systems. Our mission is to 
                            foster a love for reading and continuous learning within our community by providing easy access to a vast collection of books.
                        </p>
                    </div>
                    <div style="text-align: center;">
                        <div style="width: 250px; height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 8px 32px rgba(102,126,234,0.3);">
                            <i class="fa-solid fa-book-open-reader" style="font-size: 100px; color: #fff;"></i>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section style="margin-bottom: 50px;">
                <h2 style="text-align: center; color: #2e7d32; margin-bottom: 50px; font-size: 36px; display: flex; align-items: center; justify-content: center; gap: 15px;">
                    <i class="fa-solid fa-star"></i> Why Choose BookEase?
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
                    <div style="background: #fff; padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.1); text-align: center; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 8px 32px rgba(0,0,0,.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,.1)'">
                        <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; box-shadow: 0 4px 16px rgba(102,126,234,0.3);">
                            <i class="fa-solid fa-book" style="font-size: 48px; color: #fff;"></i>
                        </div>
                        <h3 style="color: #1b1f1b; margin-bottom: 15px; font-size: 22px; font-weight: 700;">Vast Collection</h3>
                        <p style="color: #666; line-height: 1.7; font-size: 16px; margin: 0;">Access thousands of books across various genres and categories.</p>
                    </div>
                    
                    <div style="background: #fff; padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.1); text-align: center; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 8px 32px rgba(0,0,0,.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,.1)'">
                        <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; box-shadow: 0 4px 16px rgba(240,147,251,0.3);">
                            <i class="fa-solid fa-clock" style="font-size: 48px; color: #fff;"></i>
                        </div>
                        <h3 style="color: #1b1f1b; margin-bottom: 15px; font-size: 22px; font-weight: 700;">Flexible Borrowing</h3>
                        <p style="color: #666; line-height: 1.7; font-size: 16px; margin: 0;">Borrow books for as long as you need with easy renewal options.</p>
                    </div>
                    
                    <div style="background: #fff; padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.1); text-align: center; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 8px 32px rgba(0,0,0,.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,.1)'">
                        <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; box-shadow: 0 4px 16px rgba(79,172,254,0.3);">
                            <i class="fa-solid fa-bookmark" style="font-size: 48px; color: #fff;"></i>
                        </div>
                        <h3 style="color: #1b1f1b; margin-bottom: 15px; font-size: 22px; font-weight: 700;">Reservation System</h3>
                        <p style="color: #666; line-height: 1.7; font-size: 16px; margin: 0;">Reserve books that are currently unavailable and get notified when ready.</p>
                    </div>
                    
                    <div style="background: #fff; padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.1); text-align: center; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 8px 32px rgba(0,0,0,.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,.1)'">
                        <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; box-shadow: 0 4px 16px rgba(67,233,123,0.3);">
                            <i class="fa-solid fa-mobile-screen" style="font-size: 48px; color: #fff;"></i>
                        </div>
                        <h3 style="color: #1b1f1b; margin-bottom: 15px; font-size: 22px; font-weight: 700;">Easy Access</h3>
                        <p style="color: #666; line-height: 1.7; font-size: 16px; margin: 0;">Manage your borrowings, reservations, and payments all in one place.</p>
                    </div>
                </div>
            </section>

            <!-- Stats Section -->
            <section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 60px 40px; border-radius: 16px; margin-bottom: 50px; box-shadow: 0 8px 32px rgba(0,0,0,.15); position: relative; overflow: hidden;">
                <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: relative; z-index: 1;">
                    <h2 style="text-align: center; margin-bottom: 50px; font-size: 36px; display: flex; align-items: center; justify-content: center; gap: 15px;">
                        <i class="fa-solid fa-chart-line"></i> BookEase by the Numbers
                    </h2>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; text-align: center;">
                        <div style="transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                            <div style="font-size: 56px; font-weight: 700; margin-bottom: 12px;">{{ number_format(\App\Models\Book::count()) }}</div>
                            <div style="font-size: 18px; opacity: 0.9;">Books Available</div>
                        </div>
                        <div style="transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                            <div style="font-size: 56px; font-weight: 700; margin-bottom: 12px;">{{ number_format(\App\Models\User::where('role', 'user')->count()) }}</div>
                            <div style="font-size: 18px; opacity: 0.9;">Happy Readers</div>
                        </div>
                        <div style="transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                            <div style="font-size: 56px; font-weight: 700; margin-bottom: 12px;">{{ number_format(\App\Models\BorrowedBook::count()) }}</div>
                            <div style="font-size: 18px; opacity: 0.9;">Books Borrowed</div>
                        </div>
                        <div style="transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                            <div style="font-size: 56px; font-weight: 700; margin-bottom: 12px;">24/7</div>
                            <div style="font-size: 18px; opacity: 0.9;">Online Access</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact CTA -->
            <section style="text-align: center; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 60px 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.1);">
                <h2 style="color: #2e7d32; margin-bottom: 20px; font-size: 36px; display: flex; align-items: center; justify-content: center; gap: 15px;">
                    <i class="fa-solid fa-envelope"></i> Have Questions?
                </h2>
                <p style="color: #666; margin-bottom: 35px; font-size: 20px; max-width: 600px; margin-left: auto; margin-right: auto;">
                    We're here to help! Contact us for any inquiries or support.
                </p>
                <a href="{{ route('contact') }}" class="btn primary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 12px; padding: 18px 36px; font-size: 18px; font-weight: 600; box-shadow: 0 4px 16px rgba(46,125,50,0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 24px rgba(46,125,50,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(46,125,50,0.3)'">
                    <i class="fa-solid fa-envelope"></i> Contact Us
                </a>
            </section>
        </div>
    </main>
</x-layout>
