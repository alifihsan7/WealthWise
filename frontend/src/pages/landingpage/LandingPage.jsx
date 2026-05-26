import React, { useState } from "react";
import { useNavigate } from "react-router-dom";

// Import gambar dari assets (Pastikan path-nya benar)
import landingImage1 from "../../assets/fiture1landingpage.jpeg";
import landingImage2 from "../../assets/fiture2landingpage.jpg";

export default function LandingPage() {
  const navigate = useNavigate();
  
  // State untuk animasi hover tombol Login/Register
  const [hoverAuth, setHoverAuth] = useState("register");
  
  // State untuk Popups
  const [showTerms, setShowTerms] = useState(false);
  const [showPrivacy, setShowPrivacy] = useState(false);
  const [showContact, setShowContact] = useState(false);

  return (
    <div className="min-h-screen font-sans selection:bg-emerald-500 selection:text-white flex flex-col relative">
      
      {/* ======================= MODAL TERMS OF SERVICES ======================= */}
      {showTerms && (
        <div className="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 animate-in fade-in duration-300">
          <div className="bg-[#FAFBFB] rounded-3xl p-8 md:p-12 w-full max-w-4xl shadow-2xl relative max-h-[90vh] overflow-y-auto animate-in zoom-in-95 duration-300">
            <button 
              onClick={() => setShowTerms(false)}
              className="absolute top-6 right-6 p-2 bg-gray-200/50 hover:bg-gray-200 text-gray-500 hover:text-gray-800 rounded-full transition-colors"
            >
              <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>

            <div className="text-center mb-10">
              <h2 className="text-3xl md:text-4xl font-extrabold text-[#1F2937] mb-2 tracking-tight">
                Terms of Services
              </h2>
              <p className="text-[#E2E8F0] font-medium tracking-wide">
                Have questions or need help? Get in touch with us!
              </p>
            </div>

            <div className="text-[#1F2937] leading-relaxed text-sm md:text-base px-2 md:px-6">
              <p className="font-bold mb-4">
                By accessing or using WealthWise, you agree to comply with and be bound by the following terms and conditions:
              </p>
              <ul className="space-y-4 list-disc pl-5 marker:text-gray-400">
                <li><b className="font-bold">Service Overview:</b> WealthWise is a digital platform designed for personal finance management, including expense tracking, budgeting, and category organization. The service is provided "as is" for your personal, non-commercial use.</li>
                <li><b className="font-bold">User Eligibility:</b> You must provide accurate and complete information during registration. You are solely responsible for any activity that occurs under your account and for maintaining the security of your password.</li>
                <li><b className="font-bold">Financial Disclaimer:</b> WealthWise is an administrative tool only. We do not provide professional financial advice, auditing, or tax services. Any calculations or insights provided are for informational purposes; always consult with a certified professional for significant financial decisions.</li>
                <li><b className="font-bold">Acceptable Use:</b> You agree not to misuse the service by attempting to bypass security measures, injecting malicious code, or using the platform for any illegal financial transactions or fraudulent activities.</li>
                <li><b className="font-bold">Termination:</b> We reserve the right to suspend or terminate your access to the service at any time, without notice, for conduct that we believe violates these Terms or is harmful to other users or our business interests.</li>
              </ul>
            </div>
          </div>
        </div>
      )}

      {/* ======================= MODAL PRIVACY POLICY ======================= */}
      {showPrivacy && (
        <div className="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 animate-in fade-in duration-300">
          <div className="bg-[#FAFBFB] rounded-3xl p-8 md:p-12 w-full max-w-4xl shadow-2xl relative max-h-[90vh] overflow-y-auto animate-in zoom-in-95 duration-300">
            <button 
              onClick={() => setShowPrivacy(false)}
              className="absolute top-6 right-6 p-2 bg-gray-200/50 hover:bg-gray-200 text-gray-500 hover:text-gray-800 rounded-full transition-colors"
            >
              <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>

            <div className="text-center mb-10">
              <h2 className="text-3xl md:text-4xl font-extrabold text-[#1F2937] mb-2 tracking-tight">
                Privacy Policy
              </h2>
              <p className="text-[#E2E8F0] font-medium tracking-wide">
                Have questions or need help? Get in touch with us!
              </p>
            </div>

            <div className="text-[#1F2937] leading-relaxed text-sm md:text-base px-2 md:px-6">
              <p className="font-bold mb-4">
                We respect your privacy and are committed to protecting the personal data you share with us:
              </p>
              <ul className="space-y-4 list-disc pl-5 marker:text-gray-400">
                <li><b className="font-bold">Data Collection:</b> We collect information you provide directly, such as your name and email address, and data generated through your use of the app, including transaction history, budget limits, and custom financial categories.</li>
                <li><b className="font-bold">Purpose of Processing:</b> We process your data to personalize your dashboard, provide accurate financial reports, and improve the application's performance. If you opt-in, we may use your data to send service updates or security alerts.</li>
                <li><b className="font-bold">Data Sharing & Disclosure:</b> We do not sell your personal or financial information to third-party advertisers. Data may only be shared with essential service providers (e.g., cloud hosting) or when legally required by Indonesian law.</li>
                <li><b className="font-bold">Cookies and Tracking:</b> We may use cookies and similar tracking technologies to analyze app traffic and remember your preferences to provide a seamless user experience.</li>
                <li><b className="font-bold">Global Compliance:</b> While we are based in Indonesia, we strive to follow best practices in data protection to ensure your information is handled with the highest level of care.</li>
              </ul>
            </div>
          </div>
        </div>
      )}

      {/* ======================= MODAL CONTACT INFO (TANPA FORM) ======================= */}
      {showContact && (
        <div className="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 animate-in fade-in duration-300">
          <div className="bg-white rounded-[2rem] w-full max-w-lg shadow-2xl relative overflow-hidden flex flex-col animate-in zoom-in-95 duration-300">
            
            {/* Tombol Close */}
            <button 
              onClick={() => setShowContact(false)} 
              className="absolute top-4 right-4 p-2 z-[110] bg-white/20 hover:bg-white/40 text-white backdrop-blur-md rounded-full transition-colors"
            >
              <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>

            {/* Bagian Atas: Peta Cover */}
            <div className="w-full h-48 bg-slate-800 relative shadow-inner">
              <img 
                src="https://images.unsplash.com/photo-1524661135-423995f22d0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                alt="Map Cover" 
                className="w-full h-full object-cover opacity-70 mix-blend-screen" 
              />
              <div className="absolute top-1/2 left-1/2 w-4 h-4 bg-red-500 rounded-full border-2 border-white shadow-[0_0_15px_rgba(239,68,68,1)] flex items-center justify-center -translate-x-1/2 -translate-y-1/2">
                <div className="w-1.5 h-1.5 bg-white rounded-full"></div>
              </div>
            </div>

            {/* Bagian Bawah: Info List */}
            <div className="p-8 flex flex-col items-center">
              <h2 className="text-3xl font-extrabold text-[#051C3A] mb-2 tracking-tight">Get in Touch</h2>
              <p className="text-gray-500 text-sm mb-8 text-center">
                We'd love to hear from you. You can reach us via the following details.
              </p>

              <div className="flex flex-col gap-4 w-full">
                
                {/* Address Item */}
                <div className="flex items-center gap-4 p-4 bg-[#F8FAFC] rounded-2xl border border-gray-100 hover:border-emerald-100 transition-colors">
                  <div className="w-12 h-12 rounded-full bg-emerald-100/50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                  </div>
                  <div>
                    <p className="text-[10px] uppercase font-bold text-gray-400 mb-0.5 tracking-wider">Office Address</p>
                    <p className="font-bold text-[#051C3A] text-sm">Jl. Lorem Ipsum No. 123</p>
                  </div>
                </div>

                {/* Phone Item */}
                <div className="flex items-center gap-4 p-4 bg-[#F8FAFC] rounded-2xl border border-gray-100 hover:border-blue-100 transition-colors">
                  <div className="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                  </div>
                  <div>
                    <p className="text-[10px] uppercase font-bold text-gray-400 mb-0.5 tracking-wider">Phone Number</p>
                    <p className="font-bold text-[#051C3A] text-sm">+62 812 3456 7890</p>
                  </div>
                </div>

                {/* Email Item */}
                <div className="flex items-center gap-4 p-4 bg-[#F8FAFC] rounded-2xl border border-gray-100 hover:border-purple-100 transition-colors">
                  <div className="w-12 h-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                  </div>
                  <div>
                    <p className="text-[10px] uppercase font-bold text-gray-400 mb-0.5 tracking-wider">Email Support</p>
                    <p className="font-bold text-[#051C3A] text-sm">wlw@wlw.com</p>
                  </div>
                </div>

              </div>
            </div>
            
          </div>
        </div>
      )}
      {/* ========================================================================= */}


      {/* NAVBAR */}
      <nav className="w-full bg-[#0B644B] px-6 lg:px-12 py-4 flex justify-between items-center z-50 shadow-md">
        <div className="flex items-center gap-2 cursor-pointer group" onClick={() => navigate("/")}>
          <div className="w-8 h-8 bg-white rounded-full flex items-center justify-center transition-transform duration-300 group-hover:rotate-12">
            <span className="text-[#0B644B] font-black text-xs">WW</span>
          </div>
          <span className="text-xl font-bold text-white tracking-tight">
            WealthWise
          </span>
        </div>

        <div className="hidden md:flex items-center gap-8">
          <a href="#features" className="text-sm font-medium text-emerald-100 hover:text-white hover:-translate-y-0.5 transition-all duration-300">Features</a>
        </div>

        <div 
          className="flex items-center p-1 bg-[#09503c] rounded-full border border-emerald-700/50 shadow-inner"
          onMouseLeave={() => setHoverAuth("register")}
        >
          <button 
            onMouseEnter={() => setHoverAuth("login")}
            onClick={() => navigate("/login")}
            className={`px-6 py-2 rounded-full text-sm font-bold transition-all duration-300 ${
              hoverAuth === "login" 
                ? "bg-white text-[#0B644B] shadow-md scale-100" 
                : "text-emerald-100 hover:text-white scale-95"
            }`}
          >
            Login
          </button>
          
          <button 
            onMouseEnter={() => setHoverAuth("register")}
            onClick={() => navigate("/register")}
            className={`px-6 py-2 rounded-full text-sm font-bold transition-all duration-300 ${
              hoverAuth === "register" 
                ? "bg-white text-[#0B644B] shadow-md scale-100" 
                : "text-emerald-100 hover:text-white scale-95"
            }`}
          >
            Register
          </button>
        </div>
      </nav>

      {/* HERO SECTION */}
      <section className="bg-[#16181C] w-full pt-20 pb-28 px-6 lg:px-12 relative overflow-hidden flex-1">
        <div className="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center relative z-10">
          <div>
            <div className="inline-flex items-center gap-2 bg-white/5 border border-white/10 text-gray-300 px-4 py-1.5 rounded-full text-[11px] font-medium tracking-wide uppercase mb-6 backdrop-blur-sm hover:bg-white/10 transition-colors cursor-default">
              <span className="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
              The New Standard in Wealth Management
            </div>
            
            <h1 className="text-5xl md:text-6xl lg:text-[72px] font-extrabold text-white tracking-tight leading-[1.05] mb-6">
              Master Your <br /> Wealth <br />
              <span className="text-[#10B981]">With Precision.</span>
            </h1>
            
            <p className="text-gray-400 text-base md:text-lg max-w-lg mb-10 leading-relaxed">
              Experience the financial atelier. Curate your assets, track intelligent
              insights, and navigate your financial journey with editorial clarity.
            </p>
            
            <button 
              onClick={() => navigate("/register")}
              className="bg-gradient-to-r from-[#0B644B] to-[#10B981] text-white px-8 py-3.5 rounded-xl text-base font-bold transition-all duration-300 shadow-lg shadow-emerald-900/30 hover:from-[#094d3a] hover:to-[#059669] hover:shadow-emerald-500/40 hover:-translate-y-1 hover:scale-105 active:scale-95"
            >
              Get Started
            </button>
          </div>

          <div className="relative w-full max-w-lg mx-auto lg:mr-0 mt-10 lg:mt-0">
            <div className="w-full aspect-[4/3] bg-[#1E293B] rounded-[2rem] border-4 border-[#2A2D35] shadow-[0_20px_50px_rgba(0,0,0,0.5)] p-3 md:p-4 relative group hover:border-[#10B981]/50 transition-colors duration-500">
               <div className="w-full h-full overflow-hidden rounded-[20px] relative bg-black">
                 <img 
                   src={landingImage1} 
                   alt="WealthWise Showcase" 
                   className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-90 group-hover:opacity-100"
                 />
                 <div className="absolute inset-0 shadow-[inset_0_0_20px_rgba(0,0,0,0.3)] pointer-events-none"></div>
               </div>
            </div>
          </div>
        </div>
      </section>

      {/* FEATURES SECTION */}
      <section id="features" className="bg-[#F8FAFC] w-full py-24 px-6 lg:px-12">
        <div className="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
          
          <div className="order-2 lg:order-1">
            <h2 className="text-3xl md:text-4xl font-extrabold text-[#051C3A] mb-4">Features</h2>
            <p className="text-gray-500 text-sm md:text-base leading-relaxed mb-10 max-w-md">
              Beyond tracking. WealthWise uses advanced algorithms to actively project and protect your financial future.
            </p>

            <div className="flex flex-col gap-8">
              <div className="flex gap-4 items-start group">
                <div className="w-6 h-6 mt-0.5 text-[#0B644B] shrink-0 transition-transform duration-300 group-hover:scale-125">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2.5"><circle cx="12" cy="12" r="9" strokeOpacity="0.2" /><circle cx="12" cy="12" r="5" /><circle cx="12" cy="12" r="1" fill="currentColor" /></svg>
                </div>
                <div>
                  <h4 className="text-[15px] font-bold text-[#051C3A] mb-1 group-hover:text-[#0B644B] transition-colors">Smart Planning & Budgeting</h4>
                  <p className="text-xs text-gray-500 leading-relaxed">Dynamic budgets that adapt to your spending patterns and market conditions.</p>
                </div>
              </div>

              <div className="flex gap-4 items-start group">
                <div className="w-6 h-6 mt-0.5 text-[#0B644B] shrink-0 transition-transform duration-300 group-hover:scale-125">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2"><path strokeLinecap="round" strokeLinejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                </div>
                <div>
                  <h4 className="text-[15px] font-bold text-[#051C3A] mb-1 group-hover:text-[#0B644B] transition-colors">Computer Vision Receipts</h4>
                  <p className="text-xs text-gray-500 leading-relaxed">Snap a photo. Our AI instantly extracts line items, dates, and vendors with zero manual entry.</p>
                </div>
              </div>

              <div className="flex gap-4 items-start group">
                <div className="w-6 h-6 mt-0.5 text-[#0B644B] shrink-0 transition-transform duration-300 group-hover:scale-125">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2.5"><path strokeLinecap="round" strokeLinejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                </div>
                <div>
                  <h4 className="text-[15px] font-bold text-[#051C3A] mb-1 group-hover:text-[#0B644B] transition-colors">Financial Health Status</h4>
                  <p className="text-xs text-gray-500 leading-relaxed">A real-time holistic score based on liquidity, debt-to-income, and asset diversification.</p>
                </div>
              </div>
            </div>
          </div> 
          
          <div className="order-1 lg:order-2 flex justify-center lg:justify-end">
            <div className="w-full max-w-[500px] aspect-[4/3] bg-white rounded-[2rem] shadow-xl border border-gray-100 p-3 md:p-4 relative group hover:border-[#10B981]/30 hover:shadow-2xl hover:shadow-[#10B981]/10 transition-all duration-500 hover:-translate-y-2">
               <div className="w-full h-full overflow-hidden rounded-[20px] relative bg-black">
                 <img 
                   src={landingImage2} 
                   alt="WealthWise Features" 
                   className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-90 group-hover:opacity-100"
                 />
                 <div className="absolute inset-0 shadow-[inset_0_0_20px_rgba(0,0,0,0.1)] pointer-events-none"></div>
               </div>
            </div>
          </div>
        </div>
      </section>

      {/* FOOTER */}
      <footer className="bg-white border-t border-gray-100 py-8 px-6 lg:px-12 mt-auto relative z-40">
        <div className="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
          <div>
            <h3 className="text-[#051C3A] font-bold text-base mb-1">WealthWise</h3>
            <p className="text-[10px] text-gray-400">
              &copy; {new Date().getFullYear()} WealthWise Financial Atelier. Built for editorial precision.
            </p>
          </div>
          
          <div className="flex gap-6 text-[11px] font-medium text-gray-500">
            <span onClick={() => setShowPrivacy(true)} className="hover:text-[#0B644B] transition-colors cursor-pointer font-bold">Privacy</span>
            <span onClick={() => setShowTerms(true)} className="hover:text-[#0B644B] transition-colors cursor-pointer font-bold">Terms</span>
            <span onClick={() => setShowContact(true)} className="hover:text-[#0B644B] transition-colors cursor-pointer font-bold">Contact</span>
          </div>
        </div>
      </footer>

    </div>
  );
}