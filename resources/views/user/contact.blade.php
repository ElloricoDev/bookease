<x-layout title="BookEase • Contact Us" bodyClass="user-page">
    <x-user-header />

    <main class="user-main">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <!-- Hero Section -->
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 60px 40px; border-radius: 16px; margin: 30px 0 50px; text-align: center; box-shadow: 0 8px 32px rgba(0,0,0,.15); position: relative; overflow: hidden;">
                <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: relative; z-index: 1;">
                    <h1 style="font-size: 48px; font-weight: 800; margin: 0 0 15px 0; text-shadow: 0 2px 10px rgba(0,0,0,.2); display: flex; align-items: center; justify-content: center; gap: 15px;">
                        <i class="fa-solid fa-envelope"></i> Contact Us
                    </h1>
                    <p style="font-size: 22px; margin: 0; opacity: 0.95; font-weight: 500;">
                        Have a question or need assistance? We'd love to hear from you!
                    </p>
                </div>
            </div>

            @if(session('success'))
                <div style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; padding: 20px 24px; border-radius: 12px; margin-bottom: 35px; border-left: 4px solid #28a745; display: flex; align-items: center; gap: 15px; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                    <i class="fa-solid fa-check-circle" style="font-size: 24px;"></i>
                    <div>
                        <strong style="font-size: 17px;">{{ session('success') }}</strong>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); color: #721c24; padding: 20px 24px; border-radius: 12px; margin-bottom: 35px; border-left: 4px solid #dc3545; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <i class="fa-solid fa-exclamation-circle" style="font-size: 24px;"></i>
                        <strong style="font-size: 17px;">Please fix the following errors:</strong>
                    </div>
                    <ul style="margin: 0; padding-left: 25px; font-size: 15px;">
                        @foreach($errors->all() as $error)
                            <li style="margin-bottom: 5px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 35px; margin-bottom: 50px;">
                <!-- Contact Information -->
                <div style="background: #fff; padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.1);">
                    <h2 style="color: #2e7d32; margin-bottom: 30px; font-size: 28px; display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-info-circle"></i> Get in Touch
                    </h2>
                    <div style="display: grid; gap: 25px;">
                        <div style="display: flex; align-items: start; gap: 18px;">
                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                                <i class="fa-solid fa-envelope" style="color: #2e7d32; font-size: 22px;"></i>
                            </div>
                            <div>
                                <h4 style="margin: 0 0 8px 0; color: #1b1f1b; font-size: 18px; font-weight: 700;">Email</h4>
                                <p style="margin: 0; color: #666; font-size: 16px;">support@bookease.com</p>
                            </div>
                        </div>
                        
                        <div style="display: flex; align-items: start; gap: 18px;">
                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                                <i class="fa-solid fa-phone" style="color: #2e7d32; font-size: 22px;"></i>
                            </div>
                            <div>
                                <h4 style="margin: 0 0 8px 0; color: #1b1f1b; font-size: 18px; font-weight: 700;">Phone</h4>
                                <p style="margin: 0; color: #666; font-size: 16px;">+1 (555) 123-4567</p>
                            </div>
                        </div>
                        
                        <div style="display: flex; align-items: start; gap: 18px;">
                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                                <i class="fa-solid fa-location-dot" style="color: #2e7d32; font-size: 22px;"></i>
                            </div>
                            <div>
                                <h4 style="margin: 0 0 8px 0; color: #1b1f1b; font-size: 18px; font-weight: 700;">Address</h4>
                                <p style="margin: 0; color: #666; font-size: 16px; line-height: 1.6;">123 Library Street<br>Book City, BC 12345</p>
                            </div>
                        </div>
                        
                        <div style="display: flex; align-items: start; gap: 18px;">
                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                                <i class="fa-solid fa-clock" style="color: #2e7d32; font-size: 22px;"></i>
                            </div>
                            <div>
                                <h4 style="margin: 0 0 8px 0; color: #1b1f1b; font-size: 18px; font-weight: 700;">Hours</h4>
                                <p style="margin: 0; color: #666; font-size: 16px; line-height: 1.6;">Mon-Fri: 9:00 AM - 6:00 PM<br>Sat-Sun: 10:00 AM - 4:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div style="background: #fff; padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.1);">
                    <h2 style="color: #2e7d32; margin-bottom: 30px; font-size: 28px; display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-paper-plane"></i> Send us a Message
                    </h2>
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        
                        <div style="margin-bottom: 22px;">
                            <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #333; font-size: 15px;">
                                <i class="fa-solid fa-user" style="color: #2e7d32; margin-right: 8px;"></i> Your Name *
                            </label>
                            <input type="text" name="name" value="{{ old('name', session('name')) }}" required
                                   style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; transition: all 0.3s;"
                                   onfocus="this.style.borderColor='#2e7d32'; this.style.boxShadow='0 0 0 3px rgba(46,125,50,0.1)'" 
                                   onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'">
                            @error('name')<span style="color: #dc3545; font-size: 13px; display: block; margin-top: 6px;">{{ $message }}</span>@enderror
                        </div>
                        
                        <div style="margin-bottom: 22px;">
                            <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #333; font-size: 15px;">
                                <i class="fa-solid fa-envelope" style="color: #2e7d32; margin-right: 8px;"></i> Your Email *
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; transition: all 0.3s;"
                                   onfocus="this.style.borderColor='#2e7d32'; this.style.boxShadow='0 0 0 3px rgba(46,125,50,0.1)'" 
                                   onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'">
                            @error('email')<span style="color: #dc3545; font-size: 13px; display: block; margin-top: 6px;">{{ $message }}</span>@enderror
                        </div>
                        
                        <div style="margin-bottom: 22px;">
                            <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #333; font-size: 15px;">
                                <i class="fa-solid fa-tag" style="color: #2e7d32; margin-right: 8px;"></i> Subject *
                            </label>
                            <input type="text" name="subject" value="{{ old('subject') }}" required
                                   style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; transition: all 0.3s;"
                                   onfocus="this.style.borderColor='#2e7d32'; this.style.boxShadow='0 0 0 3px rgba(46,125,50,0.1)'" 
                                   onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'">
                            @error('subject')<span style="color: #dc3545; font-size: 13px; display: block; margin-top: 6px;">{{ $message }}</span>@enderror
                        </div>
                        
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #333; font-size: 15px;">
                                <i class="fa-solid fa-message" style="color: #2e7d32; margin-right: 8px;"></i> Message *
                            </label>
                            <textarea name="message" rows="6" required
                                      style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; transition: all 0.3s; resize: vertical; font-family: inherit;"
                                      onfocus="this.style.borderColor='#2e7d32'; this.style.boxShadow='0 0 0 3px rgba(46,125,50,0.1)'" 
                                      onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'"
                                      placeholder="Tell us how we can help...">{{ old('message') }}</textarea>
                            @error('message')<span style="color: #dc3545; font-size: 13px; display: block; margin-top: 6px;">{{ $message }}</span>@enderror
                        </div>
                        
                        <button type="submit" class="btn primary" style="width: 100%; padding: 16px; font-size: 17px; font-weight: 600; box-shadow: 0 4px 16px rgba(46,125,50,0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 24px rgba(46,125,50,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(46,125,50,0.3)'">
                            <i class="fa-solid fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</x-layout>
