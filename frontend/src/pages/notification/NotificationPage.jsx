import React, { useState } from "react";
import MainLayout from "../../layouts/MainLayout";

export default function NotificationPage() {
  const [activeTab, setActiveTab] = useState("All");

  // Data dummy notifikasi
  const [notifications, setNotifications] = useState([
    {
      id: 1,
      type: "alert",
      title: "Budget Alert: Dining",
      message: "You've reached 92% of your monthly dining budget. Consider adjusting your spending to stay on track.",
      time: "2 hours ago",
      isRead: false,
      iconBg: "bg-[#FCA5A5]/40", 
      iconColor: "text-red-600",
      icon: (
        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
      ),
    },
    {
      id: 2,
      type: "insight",
      title: "New AI Insight Available",
      message: "Our algorithms detected a 12% optimization opportunity in your tax-advantaged accounts based on last quarter's performance.",
      time: "4 hours ago",
      isRead: false,
      iconBg: "bg-[#6EE7B7]/60", 
      iconColor: "text-[#047857]",
      icon: (
        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
        </svg>
      ),
    },
    {
      id: 3,
      type: "transaction", // Masuk ke kategori All
      title: "Salary Credited",
      message: "Your salary from Acme Corp has been successfully deposited into your primary checking account.",
      time: "Yesterday",
      tag: "TRANSACTION",
      isRead: false,
      iconBg: "bg-blue-100", 
      iconColor: "text-blue-600",
      icon: (
        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7" />
        </svg>
      ),
    },
    {
      id: 4,
      type: "system",
      title: "Security Update",
      message: "Two-factor authentication has been successfully updated on your mobile device.",
      time: "May 12, 2024",
      isRead: true, 
      iconBg: "bg-gray-300", 
      iconColor: "text-gray-600",
      icon: (
        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
      ),
    },
    {
      id: 5,
      type: "goal", // Masuk ke kategori All
      title: "Goal Progress",
      message: "Sisa Rp1.000.000 lagi untuk mencapai target Liburan ke Jepang!",
      time: "Yesterday at 11:30 PM",
      isRead: false,
      iconBg: "bg-[#6EE7B7]", 
      iconColor: "text-[#047857]",
      icon: (
        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
        </svg>
      ),
    },
  ]);

  // Fungsi untuk menghitung jumlah yang belum terbaca
  const unreadCount = notifications.filter((n) => !n.isRead).length;

  // Fungsi menandai semua sebagai terbaca
  const markAllAsRead = () => {
    setNotifications(
      notifications.map((notif) => ({ ...notif, isRead: true }))
    );
  };

  // Fungsi menandai satu notifikasi sebagai terbaca ketika di-klik
  const markAsRead = (id) => {
    setNotifications(
      notifications.map((notif) =>
        notif.id === id ? { ...notif, isRead: true } : notif
      )
    );
  };

  // Logika Filter berdasarkan Tab yang aktif
  const filteredNotifications = notifications.filter((notif) => {
    if (activeTab === "All") return true;
    if (activeTab === "Alerts") return notif.type === "alert";
    if (activeTab === "Insights") return notif.type === "insight";
    if (activeTab === "System") return notif.type === "system";
    return true;
  });

  return (
    <MainLayout isLoading={false}>
      {/* Wrapper untuk Dark Mode Content */}
      <div className="bg-[#1A1C20] min-h-[85vh] rounded-[32px] p-8 md:p-10 shadow-2xl">
        
        {/* HEADER */}
        <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
          <div className="flex items-center gap-4">
            <h1 className="text-3xl font-extrabold text-white tracking-tight">
              Notification Center
            </h1>
            {unreadCount > 0 && (
              <span className="bg-[#6EE7B7] text-[#047857] text-[11px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wide">
                {unreadCount} NEW
              </span>
            )}
          </div>
          
          <button 
            onClick={markAllAsRead}
            className="flex items-center gap-2 text-[#6EE7B7] hover:text-white transition-colors text-sm font-semibold"
          >
            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M5 13l4 4L19 7" />
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M5 18l4 4L19 12" className="opacity-50" />
            </svg>
            Mark all as read
          </button>
        </div>

        {/* TABS */}
        <div className="bg-[#132A24] inline-flex rounded-xl p-1 mb-8">
          {["All", "Alerts", "Insights", "System"].map((tab) => (
            <button
              key={tab}
              onClick={() => setActiveTab(tab)}
              className={`px-6 py-2 rounded-lg text-sm transition-all ${
                activeTab === tab
                  ? "bg-[#6EE7B7] text-[#047857] font-bold shadow-sm"
                  : "text-gray-300 font-medium hover:text-white"
              }`}
            >
              {tab}
            </button>
          ))}
        </div>

        {/* NOTIFICATION LIST */}
        <div className="flex flex-col gap-4">
          {filteredNotifications.length > 0 ? (
            filteredNotifications.map((notif) => (
              <div
                key={notif.id}
                onClick={() => markAsRead(notif.id)}
                className={`flex flex-col sm:flex-row gap-5 p-6 rounded-[20px] cursor-pointer transition-all ${
                  notif.isRead 
                    ? "bg-[#D1D5DB] hover:bg-[#c4c8ce]" 
                    : "bg-white shadow-[0_4px_20px_rgba(0,0,0,0.05)] hover:bg-gray-50"
                }`}
              >
                {/* Icon */}
                <div className={`w-14 h-14 rounded-full flex items-center justify-center shrink-0 ${notif.iconBg} ${notif.iconColor}`}>
                  {notif.icon}
                </div>

                {/* Content */}
                <div className="flex-1 flex flex-col justify-center">
                  <div className="flex items-center gap-2 mb-1">
                    <h3 className={`text-lg font-bold ${notif.isRead ? "text-gray-700" : "text-[#111827]"}`}>
                      {notif.title}
                    </h3>
                    {/* Green dot for unread */}
                    {!notif.isRead && (
                      <span className="w-2.5 h-2.5 bg-[#10B981] rounded-full shrink-0"></span>
                    )}
                  </div>
                  
                  <p className={`text-sm leading-relaxed mb-3 pr-4 ${notif.isRead ? "text-gray-600" : "text-[#4B5563]"}`}>
                    {notif.message}
                  </p>
                  
                  <div className="flex items-center gap-3">
                    <span className="text-[#6B7280] text-xs font-medium">
                      {notif.time}
                    </span>
                    {notif.tag && (
                      <span className="bg-[#E5E7EB] text-[#4B5563] text-[10px] font-bold px-2 py-1 rounded tracking-wider uppercase">
                        {notif.tag}
                      </span>
                    )}
                  </div>
                </div>
              </div>
            ))
          ) : (
            // Placeholder jika filter kosong
            <div className="text-center py-10">
              <p className="text-gray-400 font-medium">Tidak ada notifikasi di kategori ini.</p>
            </div>
          )}
        </div>

        {/* LOAD MORE BUTTON */}
        {filteredNotifications.length > 0 && (
          <div className="mt-8 flex justify-center">
            <button className="bg-[#E5E7EB] hover:bg-[#D1D5DB] transition-colors text-[#111827] font-semibold py-3 px-6 rounded-full text-sm flex items-center gap-2">
              Load previous notifications
              <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
          </div>
        )}

      </div>
    </MainLayout>
  );
}